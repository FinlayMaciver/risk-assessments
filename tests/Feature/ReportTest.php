<?php

namespace Tests\Feature;

use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use Tests\TestCase;

class ReportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function regular_users_cant_see_the_report_pages()
    {
        $user = User::factory()->create();

        foreach ($this->getReportRoutes() as $route) {
            $this->actingAs($user)->get($route)->assertStatus(Response::HTTP_FORBIDDEN);
        };
    }

    /** @test */
    public function admins_can_see_the_report_pages()
    {
        $admin = User::factory()->admin()->create();

        foreach ($this->getReportRoutes() as $route) {
            $this->actingAs($admin)->get($route)->assertStatus(Response::HTTP_OK);
        };
    }

    /** @test */
    public function the_expiring_report_shows_the_correct_data_and_can_be_filtered()
    {
        $admin = User::factory()->admin()->create();
        $recentForm1 = Form::factory()->create(['title' => 'AAAAA', 'review_date' => now()->addDays(200)]);
        $recentForm2 = Form::factory()->create(['title' => 'BBBBB', 'review_date' => now()->addDays(90)]);
        $expiringForm1 = Form::factory()->create(['title' => 'CCCCC', 'review_date' => now()->addDays(30)]);
        $expiringForm2 = Form::factory()->create(['title' => 'DDDDD', 'review_date' => now()->addDays(10)]);

        $this->actingAs($admin)->get(route('report.expiring'))->assertSeeLivewire('report.expiring');

        Livewire::actingAs($admin)->test('report.expiring')
            ->assertDontSee($recentForm1->title)
            ->assertDontSee($recentForm2->title)
            ->assertSee($expiringForm1->title)
            ->assertSee($expiringForm2->title)
            ->set('filter', $expiringForm1->title)
            ->assertSee($expiringForm1->title)
            ->assertDontSee($expiringForm2->title)
            ->set('filter', '')
            ->assertSee($expiringForm1->title)
            ->assertSee($expiringForm2->title)
            ->set('expiresInDays', 12)
            ->assertDontSee($expiringForm1->title)
            ->assertSee($expiringForm2->title);
    }



    protected function getReportRoutes(): array
    {
        return [
            route('report.expiring'),
        ];
    }
}

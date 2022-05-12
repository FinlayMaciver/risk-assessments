<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /** @test */
    public function regular_users_cant_see_the_report_pages()
    {
        $user = User::factory()->create();

        foreach ($this->getReportRoutes() as $route) {
            $this->actingAs($user)->get($route)->assertStatus(Response::HTTP_FORBIDDEN);
        };
    }

    protected function getReportRoutes(): array
    {
        return [
            route('report.expiring'),
        ];
    }
}

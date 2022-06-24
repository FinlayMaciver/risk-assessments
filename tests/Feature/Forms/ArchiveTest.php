<?php

namespace Tests\Feature\Forms;

use App\Models\Form;
use App\Models\User;
use Tests\TestCase;

class ArchiveTest extends TestCase
{
    /** @test */
    public function can_archive_a_form()
    {
        $admin = User::factory()->admin()->create();
        $form = Form::factory()->create();

        $this->actingAs($admin)
            ->post(route('form.archive', $form))
            ->assertRedirect(route('form.show', $form));

        $this->assertTrue($form->fresh()->is_archived);
    }

    /** @test */
    public function only_admins_can_archive()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();
        $form = Form::factory()->create();

        $this->actingAs($user)
            ->post(route('form.archive', $form))
            ->assertStatus(403);
        $this->assertFalse($form->fresh()->is_archived);

        $this->actingAs($admin)
            ->post(route('form.archive', $form))
            ->assertRedirect(route('form.show', $form));

        $this->assertTrue($form->fresh()->is_archived);
    }

    /** @test */
    public function cant_edit_an_archived_form()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create(['user_id' => $user->id, 'is_archived' => true]);

        $this->actingAs($user)
            ->get(route('form.edit', $form->id))
            ->assertStatus(403);
        $this->assertTrue($form->fresh()->is_archived);
    }

    /** @test */
    public function can_see_list_of_archived_forms()
    {
        $admin = User::factory()->admin()->create();
        $currentForm = Form::factory()->create();
        $archivedForm = Form::factory()->archived()->create();

        $this->actingAs($admin)
            ->get(route('form.archived'))
            ->assertStatus(200)
            ->assertSee($archivedForm->title)
            ->assertDontSee($currentForm->title);
    }
}

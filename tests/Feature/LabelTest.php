<?php

namespace Tests\Feature;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->authUser();
    }

    public function testUserCanCreateNewLabel()
    {
        // $label = $this->createLabel();
        // & using factory()->raw() help you to make input data using factory but when we call the raw() its not create the data in database
        $labelInput = Label::factory()->raw();
        // & while using create() it will create the data in database
        // $labelInput = $this->createLabel()->toArray();

        $response = $this->postJson('/api/label', $labelInput)->assertCreated();

        $this->assertDatabaseHas('labels', $labelInput);
        // $this->assertDatabaseHas('labels', [
        //     'title' => $labelInput['title'],
        //     'color' => $labelInput['color'],
        // ]);
        $totalLabel = DB::table('labels')->count();
        Log::info('total label: ' . $totalLabel);
    }
    
    public function testUserOnCreateLabelButFieldRequiredFilledByEmptyValue()
    {
        $labelInput = Label::factory()->raw([
            'color' => null,
        ]);

        $this->postJson('/api/label', $labelInput)->assertUnprocessable()
        ->assertJsonValidationErrors(['color']);
    }

    public function testUserCanUpdateLabel()
    {
        $label = $this->createLabel();

        $labelInput = Label::factory()->raw();

        $response = $this->putJson('/api/label/' . $label->id, $labelInput)->assertOk();
        Log::info('response: ' . $response->getContent() . '\n status: ' . $response->getStatusCode());
        
        $this->assertDatabaseHas('labels', $labelInput);
    }
}

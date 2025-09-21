<?php

namespace App\Http\Controllers;

use App\Models\goal;
use App\Models\goalcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function goalCreate(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'gname'      => 'required|string|max:255',
            'current'    => 'required|numeric|min:0',
            'target'     => 'required|numeric|min:0',
            'date'       => 'required|date',
            'status'     => 'required',
        ]);
    
        $categoryId = $request->category_id ?? null;
    
        if ($categoryId) {
            // Update existing category
            $category = goalcategory::findOrFail($categoryId);
            $category->name = $validated['gname'];
            $category->type = 2;
            $category->save();
    
            // Update associated goal
            $goal = goal::where('goal_category_id', $categoryId)->first();
            if ($goal) {
                $goal->target_amount = $validated['target'];
                $goal->current_amount = $validated['current'];
                $goal->target_date = $validated['date'];
                $goal->status = $validated['status'];
                $goal->save();
            }
    
        } else {
            // Create new category
            $category = new goalcategory();
            $category->name = $validated['gname'];
            $category->type = 2; 
            $category->user_id = Auth::id();
            $category->save();
    
            // Create associated goal
            $goal = new goal();
            $goal->goal_category_id = $category->id;
            $goal->user_id = Auth::id();
            $goal->target_amount = $validated['target'];
            $goal->current_amount = $validated['current'];
            $goal->target_date = $validated['date'];
            $goal->status = $validated['status'];
            $goal->save();
        }
    
        return redirect()->back()->with('message', 'Goal Category & Goal saved successfully');
    }
        }


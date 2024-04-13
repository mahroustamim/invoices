<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    
    function __construct()
    {
        $this->middleware(['permission:الاقسام'], ['only' => ['index']]);
        $this->middleware(['permission:إضافة قسم'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:تعديل قسم'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:حذف قسم'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $sections = Section::paginate(10);
        return view('sections.sections', compact('sections'));
    }


    public function store(Request $request)
    {
       $request->validate([
            'section_name' => 'required|unique:sections,section_name|max:30',
        ], [
            'section_name.required' => 'إسم القسم مطلوب',
            'section_name.unique' => 'إسم القسم مسجل مسبقا',
            'section_name.max' => 'يجب ألا تعدي 30 حرف',
        ]);
        

        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (auth()->user()->name),
        ]);

        return redirect('/sections')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'section_name' => 'required|max:30|unique:sections,section_name,' . $id,
        ], [
            'section_name.required' => 'إسم القسم مطلوب',
            'section_name.unique' => 'إسم القسم مسجل مسبقا',
            'section_name.max' => 'يجب ألا تعدي 30 حرف',
        ]);

        Section::where('id', $id)->update([
            'section_name' => $request->section_name,
            'description'  => $request->description,
        ]);

        // $section = Section::findOrFail($id);
        // $section->update([
        //     'section_name' => $request->section_name,
        //     'description'  => $request->description,
        // ]);

        return redirect('/sections')->with('success', 'تم تعديل المنتج بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        // return back()->with('success', 'تم حذف القسم بنجاح');
        return redirect('/sections')->with('success', 'تم حذف القسم بنجاح');
    }


}

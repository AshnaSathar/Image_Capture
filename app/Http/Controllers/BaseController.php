<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class BaseController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $items = $this->model->all();
        return view($this->getViewName('index'), compact('items'));
    }

    public function create()
    {
        return view($this->getViewName('create'));
    }

    public function store(Request $request)
    {
        $this->model->create($request->all());
        return redirect()->route($this->getRouteName('index'))->with('success', 'Record created successfully');
    }

    public function show($id)
    {
        $item = $this->model->findOrFail($id);
        return view($this->getViewName('show'), compact('item'));
    }

    public function edit($id)
    {
        $item = $this->model->findOrFail($id);
        return view($this->getViewName('edit'), compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = $this->model->findOrFail($id);
        $item->update($request->all());
        return redirect()->route($this->getRouteName('index'))->with('success', 'Record updated successfully');
    }

    public function destroy($id)
    {
        $item = $this->model->findOrFail($id);
        $item->delete();
        return redirect()->route($this->getRouteName('index'))->with('success', 'Record deleted successfully');
    }

    protected function getViewName($action)
    {
        return strtolower(class_basename($this->model)) . 's.' . $action;
    }

    protected function getRouteName($action)
    {
        return strtolower(class_basename($this->model)) . 's.' . $action;
    }
}

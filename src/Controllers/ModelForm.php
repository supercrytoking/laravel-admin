<?php

namespace Encore\Admin\Controllers;

trait ModelForm
{
    public function show($id)
    {
        return $this->edit($id);
    }

    public function update($id)
    {
        return $this->form()->update($id);
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => 'delete success!'
            ]);
        }
    }

    public function store()
    {
        return $this->form()->store();
    }
}

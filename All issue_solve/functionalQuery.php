<?php
$data = Model::where(function($query) {
    if (request()->has('date')) {
        $query->whereDate('created_at', request('date'));
        $query->whereBetween('created_at', [request()->from_date, Carbon::parse(request()->to_date)->addDay()]);
    }
})->get();

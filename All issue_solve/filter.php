<?php
        $last_day = Carbon::now()->subDay();
        $today_date = Carbon::now()->addDay();

        if ( isset($request->from_date) && isset($request->to_date) ) {
            $from_date = Carbon::parse($request->from_date);
            $to_date = Carbon::parse($request->to_date)->addDay();
        }elseif( isset($request->from_date) ){
            $from_date = Carbon::parse($request->from_date);
            $to_date = $today_date;
        }elseif( isset($request->to_date) ){
            $from_date = $last_day;
            $to_date = Carbon::parse($request->to_date)->addDay();
        }else{
            $from_date = $last_day;
            $to_date = $today_date;
        }
        $data['from_date'] = Carbon::parse($from_date)->format('Y-m-d');
        $data['to_date'] = Carbon::parse($to_date)->format('Y-m-d');


        $search = $request->all();



        $data['sendMoneys'] = DB::table('send_money')
                        ->whereIn('send_money.local_agent_tr_status', ['10','11'])
                        ->where('send_money.transaction_payment_type', 'LOCAL AGENT')
                        ->join('users', 'send_money.user_id', '=', 'users.id')
                        ->join('recipients as r', 'send_money.recipient_id', '=', 'r.id')
                        ->leftJoin('localagents_transferlist as tr','send_money.id','=','tr.sendmoney_id')

                        ->select('tr.item_reference as agent_item_reference','tr.updated_at as agent_updated_at','tr.rate as agent_rate','tr.fees as agent_fees','tr.foreign_amount as agent_foreign_amount','tr.equal_amount as agent_equal_amount','users.firstname as sender_firstname','users.lastname as sender_lastname','r.street_city as recipient_city','send_money.*')
                        ->orderBy('send_money.id','DESC')
                        ->whereBetween('send_money.created_at', [$from_date, $to_date])
                        ->paginate(config('basic.paginate'));


        $data['sendMoneys']->appends($search);

        return view('admin.transfer.local_agent_transfer', $data);

<?php
        try {
            DB::table('send_money')
                ->where('invoice_', $req->sendMoney_invoice)->where('user_id', $user->id)
                ->update([
                    'transfer_status' => "7",
                    'status' => "2",
                    'payment_status' => "2",
                ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'errors' => 'Transfer cancellation failed',
                'report' => $exception->getMessage()
            ], 500);
        }

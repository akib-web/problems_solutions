<?php
function uploadImage(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'image' => 'required|image|mimes:jpg,png,jpeg|max:5120',

        ]);

        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()], 401);

        } else {

            if ($files = $request->file('image')) {

                $destinationPath = 'public/images/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);

                return response()->json(['success'=>$profileImage], 200);

            } else {

                return response()->json(['error'=>'No image found.'], 401);              }

        }

    }

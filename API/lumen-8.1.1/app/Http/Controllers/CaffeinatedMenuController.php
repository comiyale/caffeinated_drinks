<?php

namespace App\Http\Controllers;

use App\Models\CaffeinatedMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class CaffeinatedMenuController extends Controller
{

    private function consumeLogic($itemCaffeineLevel,$safeCaffeineLevel){
        return floor(($safeCaffeineLevel / $itemCaffeineLevel));
    }

    private function remainItemThatCanBeConsumed($totalThatCanBeConsumed, $userConsumed){
        $returnValue = $totalThatCanBeConsumed - $userConsumed;
        if($returnValue <= 0){
            return 0;
        }else{
            return $returnValue;
        }
    }

    public function getMenu()
    {
        return response(['data' => CaffeinatedMenu::where('status', 'ACTIVE')->orderBy('name')->get(), 'message' => 'Caffeinated Menu data', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function getItem($id)
    {
        return response(['data' => CaffeinatedMenu::find($id), 'message' => 'get item on menu by id!', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_OK')]);
    }

    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (CaffeinatedMenu::whereName($value)->count() > 0) {
                        $fail($value . ' is already used.');
                    }
                },
            ],
            'description' => 'required',
            'caffeine_quantity' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $name = $input['name'];
        $description = $input['description'];
        $caffeine_quantity = $input['caffeine_quantity'];

        $caffeinatedMenu = CaffeinatedMenu::create([
            'name' => $name,
            'description' => $description,
            'caffeine_quantity' => $caffeine_quantity,
            'status' => 'ACTIVE'
        ]);

        $saved = $caffeinatedMenu->save();

        if ($saved) {
            return response(['data' => [
                'name' => $name,
                'description' => $description,
                'caffeine_quantity' => $caffeine_quantity,
            ], 'message' => 'caffeinated Menu created!', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
        } else {
            return response(['data' => [
                'name' => $name,
                'description' => $description,
                'caffeine_quantity' => $caffeine_quantity,
            ], 'message' => "unable to create caffeinated Menu, something went wrong.", 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function updateItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'caffeine_quantity' => 'required',
            'id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(CaffeinatedMenu::find($value))) {
                        $fail('ID ' . $value . ' does not exist.');
                    }

                    if(!is_numeric($value)){
                        $fail($value . ' (id) is not numeric');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], env('HTTP_SERVER_CODE_UNPROCESSABLE_ENTITY') );
        }

        $input = $request->all();
        $name = $input['name'];
        $description = $input['description'];
        $caffeine_quantity = $input['caffeine_quantity'];
        $id = $input['id'];

        $caffeinatedMenu = CaffeinatedMenu::findOrFail($id);
        $caffeinatedMenu->name = $name;
        $caffeinatedMenu->description = $description;
        $caffeinatedMenu->caffeine_quantity = $caffeine_quantity;
        $saved = $caffeinatedMenu->save();

        if ($saved) {
            return response(['data' => [
                'name' => $name,
                'description' => $description,
                'caffeine_quantity' => $caffeine_quantity,
            ], 'message' => 'Caffeinated Menu Item updated!', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
        } else {
            return response(['data' => [
                'name' => $name,
                'description' => $description,
                'caffeine_quantity' => $caffeine_quantity,
            ], 'message' => "unable to Caffeinated Menu Item, something went wrong.", 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
        $caffeinatedMenu->update($request->all());

        return response()->json($caffeinatedMenu, 200);
    }

    public function consumeItem($id,$quantity){
        $values = array("item_id" => $id , "quantity" => $quantity) ;
        $validator = Validator::make($values, [
            'item_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (empty(CaffeinatedMenu::find($value))) {
                        $fail('ID ' . $value . ' does not exist.');
                    }

                    if(!is_numeric($value)){
                        $fail($value . ' item_id is not numeric');
                    }
                },
            ],
            'quantity' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(!is_numeric($value)){
                        $fail($value . ' quantity is not numeric');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' => $validator->errors(), 'status' => false], 422);
        }

        $item_id = $id;

        $resultSet = CaffeinatedMenu::findOrFail($item_id);

        if (!empty($resultSet)) {
            $itemCaffeineLevel = $resultSet->caffeine_quantity;
            $itemCaffeineUnit = $resultSet->caffeine_quantity_unit;
            $safeCaffeineLevel = env('CAFFEINE_SAFE_LEVEL');
            $safeCaffeineUnit = env('CAFFEINE_UNIT');

            $canConsume = $this->consumeLogic($itemCaffeineLevel,$safeCaffeineLevel);
            $extra = $this->remainItemThatCanBeConsumed($canConsume,$quantity);

            return response(['data' => [
                'item_id' => $item_id,
                'quantity' => $quantity,
                'canConsume' => $canConsume,
                'safeCaffeineLevel' => $safeCaffeineLevel,
                'unit' => $itemCaffeineUnit,
                'itemCaffeineLevel' => $itemCaffeineLevel,
                'extra' => $extra,
                'itemObj' => $resultSet,
            ], 'message' => 'caffeinated Menu bought!', 'status' => true, 'statusCode' => env('HTTP_SERVER_CODE_CREATED')]);
        } else {
            return response(['data' => [
                'item_id' => $item_id,
                'quantity' => $quantity,
            ], 'message' => "unable to process request, please try again.", 'status' => false, 'statusCode' => env('HTTP_SERVER_CODE_BAD_REQUEST')]);
        }
    }

    public function deleteItem($id)
    {
        $resultSet = CaffeinatedMenu::find($id);
        if(!empty($resultSet)){
            CaffeinatedMenu::findOrFail($id)->delete();
            return response('Deleted Successfully', env('HTTP_SERVER_CODE_OK'));
        }else{
            return response('ID does not exit', env('HTTP_SERVER_CODE_BAD_REQUEST'));
        }
    }
}

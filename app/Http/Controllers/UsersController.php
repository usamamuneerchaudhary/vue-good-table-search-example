<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getRecords( Request $request ) {

		$search_query = $request->searchTerm;
		$users        = User::where( 'name', 'LIKE', '%' . $search_query . '%' )
		                    ->get()
		                    ->toArray();

		return response()->json( [
			'users' => $users
		] );
	}
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller {

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getRecords( Request $request ) {

		$search_query = $request->searchTerm;
		$perPage      = $request->per_page;
		$users        = User::where( 'name', 'LIKE', '%' . $search_query . '%' )
		                    ->paginate( $perPage )
		                    ->toArray();
		
		if ( $search_query ) {
			$users['searchTerm'] = $search_query ?: '';
		} else {
			$users['searchTerm'] = $search_query ? null : '';
		}

		return response()->json( [
			'users' => $users
		] );
	}
}

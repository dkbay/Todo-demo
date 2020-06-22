<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Todo[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function index()
	{
		$isAdmin = Auth::user()->admin;
		if ($isAdmin) {
			return Todo::all();
		}
		return Todo::where('user_id', Auth::id())->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return int
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return $response['response'] = $validator->messages();
		}

		$todo = new Todo;
		$todo->title = $request->title;
		$todo->user_id = Auth::id();
		$todo->save();

		return Response::HTTP_OK;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param Todo $todo
	 * @return int
	 */
	public function update(Request $request,Todo $todo)
	{
		$isAdmin = Auth::user()->admin;
		$userId = Auth::id();

		if ($isAdmin || $userId == $todo->user_id) {
			$todo->title = $request->title;
			$todo->save();

			return Response::HTTP_OK;
		}

		return Response::HTTP_BAD_REQUEST;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Todo $todo
	 * @return int
	 * @throws Exception
	 */
	public function destroy(Todo $todo)
	{
		$isAdmin = Auth::user()->admin;
		$userId = Auth::id();

		if ($isAdmin || $userId == $todo->user_id) {
			$todo->delete();

			return Response::HTTP_OK;
		}

		return Response::HTTP_BAD_REQUEST;
	}
}

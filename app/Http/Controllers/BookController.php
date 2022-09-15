<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();   // SELECT * FROM books;
        $BookResources = BookResource::collection($books);

        return $this->sendResponse($BookResources, "Succesfull get books");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:4',
            'description' => 'required|min:10|max:300',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }

        $book = Book::create($input);

        return $this->sendResponse(new BookResource($book), "Book Created Successfuly");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        return $this->sendResponse(new BookResource($book), 'Book Get Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|min:4',
            'description' => 'required|min:10|max:300',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError("Validation Error", $validator->errors());
        }

        $book = Book::find($id);

        $book->name = $input['name'];
        $book->description = $input['description'];
        $book->price = $input['price'];
        $book->save();

        return $this->sendResponse(new BookResource($book), "Book Updated Successfuly");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        $book->delete();

        return $this->sendResponse([], "Book Deleted Successfuly");
    }
}

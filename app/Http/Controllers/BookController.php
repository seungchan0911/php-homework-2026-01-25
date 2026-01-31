<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\Store;
use App\Models\Rental;

class BookController extends Controller
{
    public function create() {
        return view('book.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'quantity' => 'required',
        ]);

        $store = Store::find(auth()->user()->store_id);

        if ($request->hasFile('image')) $validated['image'] = $request->file('image')->store('books', 'public');

        $data = [
            'store_id' => $store->id,
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
        ];

        if (isset($validated['image'])) {
            $data['image'] = $validated['image'];
        }

        Book::create($data);

        return redirect()->route('store_admin.index')->with('message', "책 등록이 완료되었습니다!");
    }

    public function rent(Book $book) {
        $user = auth()->user();

        if ($user->rentals()->where('book_id', $book->id)->where('is_returned', 0)->exists()) return back()->with('message', "이미 대여중입니다!");

        Rental::create([
            'store_id' => $book->store_id,
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $book->decrement('quantity');

        return back()->with('message', "대여했습니다!");
    }

    public function return(Rental $rental) {
        $rental->update(['is_returned' => 1]);
        $rental->book->increment('quantity');

        return back()->with('message', "반납되었습니다!");
    }

    public function edit($id) {
        $book = Book::find($id);

        return view('book.edit', compact('book'));
    }

    public function update(Request $request, Book $book) {
        $validated = $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'quantity' => 'required',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($validated);

        return redirect()->route('store_admin.index')->with('message', "수정이 완료되었습니다!");
    }

    public function destroy(Book $book) {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('store_admin.index')->with('message', "삭제가 완료되었습니다!");
    }
}

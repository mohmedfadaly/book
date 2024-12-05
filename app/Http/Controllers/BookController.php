<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{

    public function create()
    {
        return view('books.create');
    }

    public function borrowBook(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        $user = auth()->user();
        if ($book->is_available == 0) {
            $book->is_available = 1;
            $book->save();

            return response()->json(['message' => 'Book borrowed successfully!']);
        }

        BorrowedBook::create([
            'book_id' => $book->id,
            'borrowable_id' => $user->id,
            'borrowable_type' => User::class,
        ]);

        $book->is_available = 0;
        $book->save();
        return response()->json(['message' => 'Book borrowed successfully!']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'is_available' => 'required|boolean',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'is_available' => $request->is_available,
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $books = Book::query();
            return DataTables::of($books)
                ->addColumn('action', function ($row) {
                    return '<button data-id="' . $row->id . '" class="btn btn-sm btn-primary borrow-btn"><i>change</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('books.index');
    }
    public function exportPDF()
    {
        $books = Book::all();
        $pdf = new \Mpdf\Mpdf();
        $pdfContent = view('books.pdf', compact('books'))->render();
        $pdf->WriteHTML($pdfContent);
        return $pdf->Output('books-list.pdf', 'D');
    }
}

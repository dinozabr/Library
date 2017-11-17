<?php namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use App\AuthorsBooks;
use App\Books;
use App\Authors;

class MainController extends Controller {


    /**
     *
     */
    public function getIndex()
    {
        $allLibrary = DB::table('authors_books')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('books', 'authors_books.book_id', '=', 'books.id')
            ->select('authors.*', 'books.id', 'books.nameBook')
            ->get();
        $idBooks = DB::table('books')->select('id')->get();
        $countSoAuthors = [];
        $allAuthors = Authors::all();
        //Поиск количества книг в соавторстве

        for($i=0;$i<count($idBooks);$i++){//
            $q=DB::table('authors_books')->select('book_id')->where('book_id','=',$idBooks[$i]->id)->count();
            if($q>=2 && !in_array($q,$countSoAuthors)){
                array_push($countSoAuthors , $q-1);
            }
        }

        for($t=0;$t < count($allAuthors);$t++) {
            $allAuthors[$t]->countBook = 0;
            for ($i = 0; $i < count($allLibrary); $i++) {
                if($allLibrary[$i]->author == $allAuthors[$t]->author){
                    $allAuthors[$t]->countBook++;
                }
            }
        }

        return View::make('first')->withStatus(session::get('status'))
                                    ->with('allAuthors',$allAuthors)
                                    ->with('allLibrary',$allLibrary)
                                    ->with('countSoAuthors',$countSoAuthors);
	}
    public function postIndex()
    {
        $input = input::all();
        $input = (int)$input['selectCount'];
        $arrayBooks = [];
        $idBooks = DB::table('books')->select('id')->get();

        for($i=0;$i<count($idBooks);$i++){
            $q=DB::table('authors_books')->select('book_id')->where('book_id','=',$idBooks[$i]->id)->count();
            if($q==$input+1){
                $query = DB::table('books')->select('nameBook')->where('id','=',$idBooks[$i]->id)->get();
                array_push($arrayBooks,$query[0]->nameBook);
            }
        }

        $imp = implode(",",$arrayBooks);
        session::flash('status', $imp);
        return redirect()->back();

    }

}





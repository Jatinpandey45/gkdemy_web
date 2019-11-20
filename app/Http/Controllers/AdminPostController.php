<?php

namespace App\Http\Controllers;

use App\Category;
use App\GkCategoryPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\MonthTags;
use App\Posts;
use App\PostSeo;
use App\Tags;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $category = Category::all();
        $month    = MonthTags::all();

        return view('admin.posts.create', compact('category', 'month'));
    }

    /**43w2q4 
     * Store a newly created resource in storage.
     *wq
     *   
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {


        /**
         * 
         *  start storing 
         * 
         */


        try {
            DB::beginTransaction();
            // database queries here

            /*
            |
            | store all post data into the database.
            |
            */

            $post = new Posts;
            $post->post_title = $request->get('post_title');
            $post->post_desc  = $request->get('post_desc');
            $post->month_id   = $request->get('month')[0];
            $post->lang_id    = $this->getLocalId();
            $post->emp_id     = Auth::user()->id;
            $post->featured_image  = $request->get('file_hidden', '');
            $post->publish_at   = $request->get('published_at');
            $post->target_device  = $request->get('visibility');
            $post->save();


            /*
            |
            | store tag and post data 
            |
            */

            $postSeo = new PostSeo;
            $postSeo->post_id = $post->id;
            $postSeo->keyword  = implode($request->get('post_seo_title'));
            $postSeo->description = $request->get('seo_desc');
            $postSeo->titile = "--";
            $postSeo->save();


            /**
             * store cateogry into the database
             */

            $category = $request->get('category');
            foreach ($category as $key => $val) {
                $postCategory = new GkCategoryPost;
                $postCategory->category_id = $val;
                $postCategory->post_id = $post->id;
                $postCategory->save();
            }

            DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            DB::rollBack();
        }

        return Redirect::back()->with('success', ['code' => Response::HTTP_OK, 'message' => trans('message.post_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * searchTags
     * @param : query string
     */

    public function searchTags(Request $request)
    {
        $searchTerm = $request->get('query', '');

        $result = Tags::searchTags($searchTerm);

        $returnData = [];

        if (!$result->isEmpty()) {

            foreach ($result as $key => $val) {
                $returnData[$key] = ['value' => $val->tag_name, 'data' => $val->id];
            }
        }

        return response()->json(['suggestions' => $returnData]);
    }



    /**
     * searchTags
     * @param : query string
     */

    public function searchTagsSeo(Request $request)
    {
        $searchTerm = $request->get('search', '');

        $result = Tags::searchTags($searchTerm);

        $returnData = [];

        if (!$result->isEmpty()) {

            foreach ($result as $key => $val) {
                $returnData[$key] = ['value' => $val->tag_name, 'text' => $val->tag_name];
            }
        }

        return response()->json($returnData);
    }

    /**
     * 
     * storetagData 
     * @param  : request 
     * @return : application/json
     */

    public function storetagData(Request $request)
    {

        $id = $request->get('id');

        if (is_null($id)) {

            $tag = new Tags;
            $tag->lang_id = $this->getLocalId();
            $tag->tag_name  = $request->get('tag');
            $tag->tag_slug  = str_slug($tag->tag_name, '-');
            $tag->tag_desc  = "--";
            $tag->save();

            $http_response_header =
                [
                    'code' => Response::HTTP_CREATED,
                    'message' => "New tag created",
                    'data' => [
                        'tag' => $request->get('tag'),
                        'id' => $tag->id
                    ]
                ];
        } else {

            $http_response_header =
                [
                    'code' => Response::HTTP_OK,
                    'message' => "Tag processed",
                    'data' => [
                        'tag' => $request->get('tag'),
                        'id' => $request->get('id')
                    ]
                ];
        }


        return response()->json($http_response_header);
    }
}

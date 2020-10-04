<?php

namespace App\Http\Controllers;

use App\Product;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page == null ? 1 : $request->page;
        $perPage = $request->perPage == null ? 20 : $request->perPage;
        $resume = $request->resume == null ? '' : $request->resume;

        return response()->json(Product::with('category','images')
                ->where('resume','LIKE', '%'.$resume.'%')
                ->paginate($perPage, ["*"], "",$page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        $images = $request->file('images');
        if (!is_null($images) && count($images) > 0){
            
            foreach ($images as $key => $image){
                if ($images[$key]->isValid()){
                    //validate name, type and size
                    $ext = $request->images[$key]->extension();

                    $filename = $product->id."_".$key.".".$ext;

                    $images[$key]->storeAs('/public', $filename);

                    Image::create([
                        "file_name" => $filename,
                        "product_id" => $product->id
                    ]);
                }else {
                    return response('Image is corrupted', 204);
                }
            }
        }
        return $product ? response()->json($product) : response('Insertion failed', 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category','images')->find($id);
        return $product !== null ? response()->json($product) : response('Product not found',404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product){
            return response('Product not found', 404);
        }
        
        $images = $request->file('images');

        if (!is_null($images)){
            
            foreach( $product->images as $old ){
                Storage::delete($old->file_name);
                $old->delete();
            }

            foreach ($images as $key => $image){
                if ($images[$key]->isValid()){
                    //validate name, type and size
                    $ext = $request->images[$key]->extension();

                    $filename = $product->id."_".$key.".".$ext;

                    $images[$key]->storeAs('/public', $filename);

                    Image::create([
                        "file_name" => $filename,
                        "product_id" => $product->id
                    ]);
                }else {
                    return response('Image is corrupted', 204);
                }
            }
        }
        
        return $product->update($request->all()) ? response()->json(Product::with('category','images')->where('id',$id)->get()) : response('Insertion failed', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product){
        
            $product->delete();
            return response()->json($product);            
        }
        return response('Product not found',404);
    }
}

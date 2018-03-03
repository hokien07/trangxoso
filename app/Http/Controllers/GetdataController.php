<?php

namespace App\Http\Controllers;

use App\Classes\Crawller;
use Illuminate\Http\Request;

class GetdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    /*
   * Select tinh theo vung mien
   * 0 == mien bac
   * 1 == mien trung
   * 2 == mien nam
   * 3 == xo so toan quoc -- xo si dien toan.
   * /
   *
   */

    public function get_ten_tinh_theo_vung($ma_vung) {
        $crawller = new Crawller();

        $ten_tinh_theo_vung = $crawller->select_tinh_by_vung(1);

        return view('home', compact('ten_tinh_theo_vung', 'ma_vung'));
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataBusana;
use App\Models\MasterItemPaket;
use App\Models\PaketItems;
use App\Models\PaketMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

    // berisi list2 data untuk kebutuhan input data job
class MasterPaketController extends Controller
{
    public function detailPaket(Request $request, $id)
    {
        try {
            $data = [];
            $data['paket'] = PaketMaster::select('id', 'nama_paket')
                ->where('id', $id)
                ->first();
            
            $items = DB::table('paket_items')
                ->select(
                    'paket_items.id',
                    'paket_items.id_paket_master',
                    'paket_items.id_master_item_paket',
                    'paket_items.volume',
                    'master_item_paket.nama_item',
                    'master_item_paket.id_jenis',
                    'master_jenis_item_paket.nama_jenis',
                    DB::raw('COALESCE(master_item_paket_harga.harga, 0) AS harga_satuan'),
                    DB::raw('COALESCE(master_item_paket_harga.harga, 0) * paket_items.volume AS harga_paket') // harga total per item
                )
                ->leftJoin('paket_master', 'paket_items.id_paket_master', '=', 'paket_master.id')
                ->leftJoin('master_item_paket', 'paket_items.id_master_item_paket', '=', 'master_item_paket.id')
                ->leftJoin('master_jenis_item_paket', 'master_jenis_item_paket.id', '=', 'master_item_paket.id_jenis')
                ->leftJoin('master_item_paket_harga', function($join) {
                    $join->on('paket_items.id_master_item_paket', '=', 'master_item_paket_harga.id_master_item_paket')
                        ->on('master_item_paket_harga.kategori', '=', 'paket_master.jenis_paket')
                        ->on('master_item_paket_harga.id_master_mua', '=', 'paket_master.id_mua');
                })
                ->where('paket_items.id_paket_master', $id)
                ->orderBy('master_item_paket.order_item', 'asc')
                ->get();
            
            // Pilihan groupBy berdasarkan parameter request
            $groupBy = $request->input('group_by'); // nilai: 'nama_jenis', 'id_jenis', atau null
            
            if ($groupBy) {
                $data['items'] = $items->groupBy($groupBy);
            } else {
                $data['items'] = $items;
            }

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function busanaPerempuan()
    {
        try {
            $data = DataBusana::select('id', 'nama_busana')
                ->where('id_tipe_busana', 1) // tipe busana Kebaya/Gown
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function busanaLaki()
    {
        try {
            $data = DataBusana::select('id', 'nama_busana')
                ->where('id_tipe_busana', 2) // tipe busana Jas/Beskap
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function setPendamping()
    {
        try {
            $data = DataBusana::select('id', 'nama_busana')
                ->where('id_tipe_busana', 3) // tipe busana Set Pendamping
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function itemPendamping(Request $request)
    {
        try {
            $id_master_mua = $request->input('id_master_mua');
            $kategori = $request->input('kategori');
            
            $data = MasterItemPaket::select('id', 'nama_item')
                ->with(['hargaItem' => function($query) use ($id_master_mua, $kategori) {
                    if ($id_master_mua) {
                        $query->where('id_master_mua', $id_master_mua);
                    }
                    if ($kategori) {
                        $query->where('kategori', $kategori);
                    }
                }])
                ->where('id_jenis', 2) // id_jenis=2 [Make up dan Busana Pendamping]
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function itemDekorasi(Request $request)
    {
        try {
            $id_master_mua = $request->input('id_master_mua');
            $kategori = $request->input('kategori');
            
            $data = MasterItemPaket::select('id', 'nama_item')
                ->with(['hargaItem' => function($query) use ($id_master_mua, $kategori) {
                    if ($id_master_mua) {
                        $query->where('id_master_mua', $id_master_mua);
                    }
                    if ($kategori) {
                        $query->where('kategori', $kategori);
                    }
                }])
                ->where('id_jenis', 3) // id_jenis=3 [Dekorasi]
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function itemEntertain(Request $request)
    {
        try {
            $id_master_mua = $request->input('id_master_mua');
            $kategori = $request->input('kategori');
            
            $data = MasterItemPaket::select('id', 'nama_item')
                ->with(['hargaItem' => function($query) use ($id_master_mua, $kategori) {
                    if ($id_master_mua) {
                        $query->where('id_master_mua', $id_master_mua);
                    }
                    if ($kategori) {
                        $query->where('kategori', $kategori);
                    }
                }])
                ->where('id_jenis', 5) // id_jenis=5 [Entertain]
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function itemProperti(Request $request)
    {
        try {
            $id_master_mua = $request->input('id_master_mua');
            $kategori = $request->input('kategori');
            
            $data = MasterItemPaket::select('id', 'nama_item')
                ->with(['hargaItem' => function($query) use ($id_master_mua, $kategori) {
                    if ($id_master_mua) {
                        $query->where('id_master_mua', $id_master_mua);
                    }
                    if ($kategori) {
                        $query->where('kategori', $kategori);
                    }
                }])
                ->where('id_jenis', 6) // id_jenis=6 [Properti]
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function itemDokumentasi(Request $request)
    {
        try {
            $id_master_mua = $request->input('id_master_mua');
            $kategori = $request->input('kategori');
            
            $data = MasterItemPaket::select('id', 'nama_item')
                ->with(['hargaItem' => function($query) use ($id_master_mua, $kategori) {
                    if ($id_master_mua) {
                        $query->where('id_master_mua', $id_master_mua);
                    }
                    if ($kategori) {
                        $query->where('kategori', $kategori);
                    }
                }])
                ->where('id_jenis', 4) // id_jenis=4 [Dokumentasi]
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
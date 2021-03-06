<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PbgCs;
use App\Models\PbgDesain;
use Illuminate\Http\Request;
use App\Models\MasterCustomer;
use App\Models\MasterKaryawan;
use App\Models\PbgAntrianSimpan;
use App\Models\AntrianPengunjung;
use App\Models\PbgAntrianCsNomor;
use App\Events\PbgAntrianCsDisplay;
use App\Events\PbgAntrianCustomerCs;
use Illuminate\Support\Facades\Auth;
use App\Models\PbgAntrianDesainNomor;
use App\Events\PbgAntrianDesainDisplay;
use App\Events\PbgAntrianCustomerDesain;
use App\Events\PbgAntrianCsStatusDisplay;
use App\Events\PbgAntrianCsSelesaiDisplay;
use App\Events\PbgAntrianCustomerDisplayCs;
use App\Events\PbgAntrianDesainMulaiDisplay;
use App\Events\PbgAntrianDesainStatusDisplay;
use App\Events\PbgAntrianDesainSelesaiDisplay;
use App\Events\PbgAntrianCustomerDisplayDesain;

class PbgController extends Controller
{
    // customer 
    public function customer()
    {
        $customers = MasterCustomer::where('master_cabang_id', '5')->get();
        return view('pbg.customer.index', ['customers' => $customers]);
    }

    public function antrianCustomer()
    {
        return view('pbg.antrianCustomer');
    }

    public function antrianCustomerSearch(Request $request)
    {
        $customers = MasterCustomer::where('telepon', 'like', '%' . $request->value . '%')
            ->where('master_cabang_id', '5')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => 'berhasil ambil data',
            'customers' => $customers
        ]);
    }

    public function antrianCustomerStore(Request $request)
    {
        $data_customer = count(MasterCustomer::where('master_cabang_id', '5')->where('telepon', $request->telepon)->get());
        if ($data_customer == 0) {
            $customers = new MasterCustomer;
            $customers->nama_customer = $request->nama_customer;
            $customers->telepon = $request->telepon;
            $customers->master_cabang_id = '5';
            $customers->save();
        }

        $nomor_antrian = $request->nomor_antrian;
        $nama = $request->nama_customer;
        $telepon = $request->telepon;
        $customer_filter_id = $request->customer_filter_id;
        $antrian_total = $request->nomor_antrian;

        if ($request->customer_filter_id == '3') {

            event(new PbgAntrianCustomerCs($nomor_antrian,$nama,$telepon,$customer_filter_id));
            event(new PbgAntrianCustomerDisplayCs($antrian_total));

            $antrianNomors = new PbgAntrianCsNomor;
            
            $antrianNomorSimpans = new PbgAntrianSimpan;
            $antrianNomorSimpans->jabatan = "cs";

            $antrianPengunjung = new AntrianPengunjung;
            $antrianPengunjung->jabatan = "cs";

        } else {

            event(new PbgAntrianCustomerDesain($nomor_antrian,$nama,$telepon,$customer_filter_id));
            event(new PbgAntrianCustomerDisplayDesain($antrian_total));

            $antrianNomors = new PbgAntrianDesainNomor;
            
            $antrianNomorSimpans = new PbgAntrianSimpan;
            $antrianNomorSimpans->jabatan = "desain";

            $antrianPengunjung = new AntrianPengunjung;
            $antrianPengunjung->jabatan = "desain";

        }

        $antrianNomors->nomor_antrian = $request->nomor_antrian;
        $antrianNomors->nama_customer = $request->nama_customer;
        $antrianNomors->telepon = $request->telepon;
        $antrianNomors->customer_filter_id = $request->customer_filter_id;
        $antrianNomors->save();
        
        $antrianNomorSimpans->nomor_antrian = $request->nomor_antrian;
        $antrianNomorSimpans->nama_customer = $request->nama_customer;
        $antrianNomorSimpans->telepon = $request->telepon;
        $antrianNomorSimpans->customer_filter_id = $request->customer_filter_id;
        $antrianNomorSimpans->save();

        $antrianPengunjung->nomor_antrian = $request->nomor_antrian;
        $antrianPengunjung->nama_customer = $request->nama_customer;
        $antrianPengunjung->telepon = $request->telepon;
        $antrianPengunjung->customer_filter_id = $request->customer_filter_id;
        $antrianPengunjung->save();

        return response()->json([
            'success' => 'data berhasil disimpan'
        ]);
    }

    public function antrianCustomerForm(Request $request, $id)
    {
        if ($id == '3') {
            $nomors = PbgAntrianCsNomor::orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(PbgAntrianCsNomor::where('status','!=', '0')->get());
            $count_nomor_all = count(PbgAntrianCsNomor::get());
            return view('pbg.antrianCustomerFormCs', ['customer_filter_id' => $id, 'nomors' => $nomors, 'count_nomor_panggil' => $count_nomor_panggil, 'count_nomor_all' => $count_nomor_all]);
        } else {
            $nomors = PbgAntrianDesainNomor::orderBy('id', 'desc')->first();
            $count_nomor_panggil = count(PbgAntrianDesainNomor::where('status','!=', '0')->get());
            $count_nomor_all = count(PbgAntrianDesainNomor::get());
            return view('pbg.antrianCustomerFormDesain', ['customer_filter_id' => $id, 'nomors' => $nomors, 'count_nomor_panggil' => $count_nomor_panggil, 'count_nomor_all' => $count_nomor_all]);
        }
    }
    
    public function antrianCustomerDisplay()
    {
        $nomor_antrian = $request->nomor_antrian;
        $nama = $request->nama;
        $telepon = $request->telepon;
        $customer_filter_id = $request->customer_filter_id;
        $antrian_total = $request->nomor_antrian;

        if ($customer_filter_id == '3') {
            event(new PbgCustomerCs($nomor_antrian,$nama,$telepon,$customer_filter_id));
            event(new PbgCustomerCsDisplay($antrian_total));
        } else {
            event(new PbgCustomerDesain($nomor_antrian,$nama,$telepon,$customer_filter_id));
            event(new PbgCustomerDesainDisplay($antrian_total));
        } 
    }

    // cs 
    public function cs()
    {
        $cs = PbgCs::get();

        return view('pbg.cs.index', ['cs' => $cs]);
    }

    public function csCreate()
    {
        $karyawans = MasterKaryawan::where('master_cabang_id', '5')->where('master_jabatan_id', '4')->get();

        return view('pbg.cs.create', ['karyawans' => $karyawans]);
    }

    public function csStore(Request $request)
    {
        $cs = new PbgCs;
        $cs->nomor = $request->nomor;
        $cs->master_karyawan_id = $request->master_karyawan_id;
        $cs->created_by = Auth::user()->id;
        $cs->save();
        
        return redirect()->route('pbg.cs')->with('status', 'Data CS berhasil ditambah');
    }

    public function csEdit($id)
    {
        $cs = PbgCs::find($id);
        $karyawans = MasterKaryawan::where('master_cabang_id', '5')->where('master_jabatan_id', '4')->get();

        return view('pbg.cs.edit', ['cs' => $cs, 'karyawans' => $karyawans]);
    }

    public function csUpdate(Request $request, $id)
    {
        $cs = PbgCs::find($id);
        $cs->nomor = $request->nomor;
        $cs->master_karyawan_id = $request->master_karyawan_id;
        $cs->updated_by = Auth::user()->id;
        $cs->save();

        return redirect()->route('pbg.cs')->with('status', 'Data CS berhasil diubah');
    }

    public function csDelete(Request $request, $id)
    {
        $cs = PbgCs::find($id);
        $cs->deleted_by = Auth::user()->id;
        $cs->save();

        $cs->delete();

        return redirect()->route('pbg.cs')->with('status', 'Data CS berhasil dihapus');
    }

    public function antrianCs()
    {
        $karyawan = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgCs')->first();

        return view('pbg.antrianCs', ['karyawan' => $karyawan]);
    }

    public function antrianCsNomor()
    {
        $nomors = PbgAntrianCsNomor::where('status', '!=', '3')->get();

        return response()->json([
            'success' => 'Success',
            'data' => $nomors
        ]);
    }

    public function antrianCsOn(Request $request, $id)
    {
        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgCs')->first();
        $cs_nomor = $karyawan->pbgCs->nomor;
        $status = "on";
        $nama_cs = $karyawan->nama_panggilan;

        event(new PbgAntrianCsStatusDisplay($cs_nomor, $status, $nama_cs));

        $cs = PbgCs::find($id);
        $cs->status = "on";
        $cs->save();

        $status_cs = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgCs')->first();
        return redirect()->route('pbg.antrian.cs', ['status_cs' => $status_cs]);
    }

    public function antrianCsOff(Request $request, $id)
    {
        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgCs')->first();
        $cs_nomor = $karyawan->pbgCs->nomor;
        $status = "off";
        $nama_cs = "";

        event(new PbgAntrianCsStatusDisplay($cs_nomor, $status, $nama_cs));

        $cs = PbgCs::find($id);
        $cs->status = "off";
        $cs->save();

        $status_cs = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgCs')->first();
        return redirect()->route('pbg.antrian.cs', ['status_cs' => $status_cs]);
    }

    public function antrianCsPanggil($nomor)
    {
        $antrianNomor = PbgAntrianCsNomor::where('nomor_antrian', $nomor)->first();
        $antrianNomor->status = 1;
        $antrianNomor->save();

        $antrian_nomor = $nomor;

        event(new PbgAntrianCsDisplay($antrian_nomor));

        return redirect()->route('pbg.antrian.cs');
    }

    public function antrianCsMulai($nomor)
    {
        $antrianNomor = PbgAntrianSimpan::where('nomor_antrian', $nomor)->where('jabatan', 'cs')->update(['mulai' => Carbon::now()]);
        $antrianNomor = AntrianPengunjung::where('nomor_antrian', $nomor)->where('jabatan', 'cs')->where('status', '0')->update(['mulai' => Carbon::now()]);

        $antrianNomor = PbgAntrianCsNomor::where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrianNomor->status = 2;
        $antrianNomor->save();

        $antrian_nomor = $nomor;

        // event(new CsMulaiDisplay($antrian_nomor));

        return redirect()->route('pbg.antrian.cs');
    }

    public function antrianCsSelesai($nomor)
    {
        $antrianNomor = PbgAntrianSimpan::where('nomor_antrian', $nomor)->where('jabatan', 'cs')->update(['selesai' => Carbon::now()]);
        $antrianNomor = AntrianPengunjung::where('nomor_antrian', $nomor)->where('jabatan', 'cs')->where('status', '0')->update(['selesai' => Carbon::now(), 'master_karyawan_id' => Auth::user()->master_karyawan_id, 'master_cabang_id' => 5, 'status' => 1, 'tanggal' => Carbon::now()]);

        $antrianNomor = PbgAntrianCsNomor::where('nomor_antrian', $nomor)->where('status', 2)->first();
        $antrianNomor->status = 3;
        $antrianNomor->save();

        $keterangan = "-";

        event(new PbgAntrianCsSelesaiDisplay($keterangan));

        return redirect()->route('pbg.antrian.cs');
    }

    public function antrianCsReset()
    {
        $cs_nomors = PbgAntrianCsNomor::where('status', '3');
        $cs_nomors->delete();

        $desain_nomors = PbgAntrianDesainNomor::where('status', '3');
        $desain_nomors->delete();

        return redirect()->route('pbg.antrian.cs');
    }

    // desain
    public function desain()
    {
        $desains = PbgDesain::get();

        return view('pbg.desain.index', ['desains' => $desains]);
    }

    public function desainCreate()
    {
        $karyawans = MasterKaryawan::where('master_cabang_id', '5')->where('master_jabatan_id', '5')->get();

        return view('pbg.desain.create', ['karyawans' => $karyawans]);
    }

    public function desainStore(Request $request)
    {
        $desains = new PbgDesain;
        $desains->nomor = $request->nomor;
        $desains->master_karyawan_id = $request->master_karyawan_id;
        $desains->created_by = Auth::user()->id;
        $desains->save();

        return redirect()->route('pbg.desain')->with('status', 'Data desain berhasil ditambah');
    }

    public function desainEdit($id)
    {
        $desain = PbgDesain::find($id);
        $karyawas = MasterKaryawan::where('master_cabang_id', '2')->where('master_jabatan_id', '5')->get();

        return view('pbg.desain.edit', ['desain' => $desain, 'karyawans' => $karyawas]);
    }

    public function desainUpdate(Request $request, $id)
    {
        $desain = PbgDesain::find($id);
        $desain->nomor = $request->nomor;
        $desain->master_karyawan_id = $request->master_karyawan_id;
        $desain->updated_by = Auth::user()->id;
        $desain->save();

        return redirect()->route('pbg.desain')->with('status', 'Data berhasil diubah');
    }

    public function desainDelete(Request $request, $id)
    {
        $desain = PbgDesain::find($id);
        $desain->deleted_by = Auth::user()->id;
        $desain->save();

        $desain->delete();

        return redirect()->route('pbg.desain')->with('status', 'Data berhasil diubah');
    }

    public function antrianDesain()
    {
        
        $karyawan = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();

        return view('pbg.antrianDesain', ['karyawan' => $karyawan]);
    }

    public function antrianDesainNomor()
    {
        $nomors = PbgAntrianDesainNomor::where('status', '!=', '3')->with('masterKaryawan')->get();

        return response()->json([
            'success' => 'Success',
            'data' => $nomors
        ]);
    }

    public function antrianDesainOn(Request $request, $id)
    {
        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;
        $status = "on";
        $nama_desain = $karyawan->nama_panggilan;

        event(new PbgAntrianDesainStatusDisplay($desain_nomor, $status, $nama_desain));

        $desainer = PbgDesain::find($id);
        $desainer->status = "on";
        $desainer->save();

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    public function antrianDesainOff(Request $request, $id)
    {
        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;
        $status = "off";
        $nama_desain = "";

        event(new PbgAntrianDesainStatusDisplay($desain_nomor, $status, $nama_desain));

        $desainer = PbgDesain::find($id);
        $desainer->status = "off";
        $desainer->save();

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    public function antrianDesainPanggil($nomor)
    {
        $antrianNomor = PbgAntrianDesainNomor::where('nomor_antrian', $nomor)->where('status', 0)->first();
        $antrianNomor->status = 1;
        $antrianNomor->master_karyawan_id = Auth::user()->master_karyawan_id;
        $antrianNomor->save();

        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;
        $antrian_nomor = $nomor;

        event(new PbgAntrianDesainDisplay($desain_nomor,$antrian_nomor));

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    public function antrianDesainUpdate(Request $request)
    {
        if ($request->nama_jenis == "desain") {
            $antrianNomor = PbgAntrianDesainNomor::where('nomor_antrian', $request->nomor)->first();
            $antrianNomor->customer_filter_id = 4;
            $antrianNomor->save();
    
            $antrianNomorSimpan = PbgAntrianSimpan::where('nomor_antrian', $request->nomor)->first();
            $antrianNomorSimpan->customer_filter_id = 4;
            $antrianNomorSimpan->save();

            $antrianPengunjung = AntrianPengunjung::where('nomor_antrian', $request->nomor)
                ->where('jabatan', 'desain')
                ->where('status', '0')
                ->first();
            $antrianPengunjung->customer_filter_id = 4;
            $antrianPengunjung->save();
        } else {
            $antrianNomor = PbgAntrianDesainNomor::where('nomor_antrian', $request->nomor)->first();
            $antrianNomor->customer_filter_id = 5;
            $antrianNomor->save();

            $antrianNomorSimpan = PbgAntrianSimpan::where('nomor_antrian', $request->nomor)->first();
            $antrianNomorSimpan->customer_filter_id = 5;
            $antrianNomorSimpan->save();

            $antrianPengunjung = AntrianPengunjung::where('nomor_antrian', $request->nomor)
                ->where('jabatan', 'desain')
                ->where('status', '0')
                ->first();
            $antrianPengunjung->customer_filter_id = 5;
            $antrianPengunjung->save();
        }

        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;
        $antrian_nomor = $request->nomor;

        event(new PbgAntrianDesainDisplay($desain_nomor,$antrian_nomor));

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    public function antrianDesainMulai($nomor)
    {
        $antrianNomor = PbgAntrianSimpan::where('nomor_antrian', $nomor)->where('jabatan', 'desain')->update(['mulai' => Carbon::now()]);
        $antrianNomor = AntrianPengunjung::where('nomor_antrian', $nomor)->where('jabatan', 'desain')->where('status', '0')->update(['mulai' => Carbon::now()]);

        $antrianNomor = PbgAntrianDesainNomor::where('nomor_antrian', $nomor)->where('status', 1)->first();
        $antrianNomor->status = 2;
        $antrianNomor->master_karyawan_id = Auth::user()->master_karyawan_id;
        $antrianNomor->save();

        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;

        $antrian_nomor = $nomor;

        event(new PbgAntrianDesainMulaiDisplay($desain_nomor,$antrian_nomor));

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    public function antrianDesainSelesai($nomor)
    {
        $antrianNomor = PbgAntrianSimpan::where('nomor_antrian', $nomor)
            ->where('jabatan', 'desain')
            ->update(['selesai' => Carbon::now(), 'master_karyawan_id' => Auth::user()->master_karyawan_id]);
        $antrianNomor = AntrianPengunjung::where('nomor_antrian', $nomor)
            ->where('jabatan', 'desain')->where('status', '0')
            ->update(['selesai' => Carbon::now(), 'master_karyawan_id' => Auth::user()->master_karyawan_id, 'master_cabang_id' => 5, 'status' => 1, 'tanggal' => Carbon::now()]);

        $antrianNomor = PbgAntrianDesainNomor::where('nomor_antrian', $nomor)->where('status', 2)->first();
        $antrianNomor->status = 3;
        $antrianNomor->save();

        $idk = Auth::user()->master_karyawan_id;
        $karyawan = MasterKaryawan::where('id', $idk)->with('pbgDesain')->first();
        $desain_nomor = $karyawan->pbgDesain->nomor;

        $keterangan = "-";

        event(new PbgAntrianDesainSelesaiDisplay($desain_nomor,$keterangan));

        $status_desainer = MasterKaryawan::where('id', Auth::user()->master_karyawan_id)->with('pbgDesain')->first();
        return redirect()->route('pbg.antrian.desain', ['status_desainer' => $status_desainer]);
    }

    // display 
    public function antrianDisplay()
    {
        return view('pbg.antrianDisplay');
    }
}

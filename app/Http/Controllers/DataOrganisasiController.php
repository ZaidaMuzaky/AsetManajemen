<?php

namespace App\Http\Controllers;

use App\Models\DataOrganisasi;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\DataOrganisasiExport;
use App\Imports\DataOrganisasiImport;
use App\Models\Division;
use App\Models\UnitKerja;
use Maatwebsite\Excel\Facades\Excel;


class DataOrganisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Organisasi = DataOrganisasi::all();
        $presdir = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'President Director')->first();
        $techoperationdir = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Tecnology & Operation Director')->first();
        $financehrdir = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Finance and Human Resource Director')->first();
        $techqualitycontroldiv = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Tecnology & Quality Control Division')->first();
        $operationdiv = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Operation Division')->first();
        $financediv = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Finance Division')->first();
        $hrga = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Human Resource & General Affairs Division')->first();

        $eeim = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Engineering dan Engineering Information Management')->first();
        $ed = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Electrical Design')->first();
        $md = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Mechanical Design')->first();
        $prodtech = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Production Technology')->first();
        $iqc = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Incoming Quality Control')->first();
        $ipi = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'In Process Inspection')->first();
        $fi = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Final Inspection')->first();
        $bp = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Bidding & Pricing')->first();

        $afsale = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'After Sales')->first();
        $deputygm = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Deputy GM Sub Quality Control')->first();
        $purchase = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Purchasing')->first();
        $logcontrol = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Logistic Controlling')->first();
        $expsub = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Expedition Sub')->first();
        $warehouse = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Warehouse')->first();
        $whcsewu = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Warehouse Candi Sewu Sub')->first();
        $whsuko = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Warehouse Sukosari Sub')->first();
        $ppc = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Production Planning and Controlling')->first();
        $pwcs = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Production Workshop Candi Sewu')->first();
        $pws = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Production Workshop Sukosari')->first();
        $pwinka = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Production Workshop INKA')->first();
        $maintenance = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Maintenance')->first();
        $taxverif = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Tax & Verification')->first();
        $accbud = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Accounting & Budgeting')->first();
        $tfr = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Treasury & Fund Raising')->first();
        $hga = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'HR & General Affairs')->first();
        $csl = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Corporate Secretary & Legal')->first();
        $it = DataOrganisasi::select('nama_pejabat')->where('nama_organisasi', 'Information Technology')->first();

        // staff
        // ===========================================================================================================

        $itstaff = Pegawai::where([['unit_kerja', 'Information Technology'], ['kode_jabatan', '5']])->get('nama');
        $cslstaff = Pegawai::where([['unit_kerja', 'Corporate Secretary & Legal'], ['kode_jabatan', '5']])->get('nama');
        $hgastaff = Pegawai::where([['unit_kerja', 'HR & General Affairs'], ['kode_jabatan', '5']])->get('nama');
        $tfrstaff = Pegawai::where([['unit_kerja', 'Treasury & Fund Raising'], ['kode_jabatan', '5']])->get('nama');
        $accbudstaff = Pegawai::where([['unit_kerja', 'Accounting & Budgeting'], ['kode_jabatan', '5']])->get('nama');
        $taxverifstaff = Pegawai::where([['unit_kerja', 'Tax & Verification'], ['kode_jabatan', '5']])->get('nama');

        $eeimstaff = Pegawai::where([['unit_kerja', 'Engineering dan Engineering Information Management'], ['kode_jabatan', '5']])->get('nama');
        $edstaff = Pegawai::where([['unit_kerja', 'Electrical Design'], ['kode_jabatan', '5']])->get('nama');
        $mdstaff = Pegawai::where([['unit_kerja', 'Mechanical Design'], ['kode_jabatan', '5']])->get('nama');
        $ptstaff = Pegawai::where([['unit_kerja', 'Production Technology'], ['kode_jabatan', '5']])->get('nama');

        $pstaff = Pegawai::where([['unit_kerja', 'Purchasing'], ['kode_jabatan', '5']])->get('nama');
        $lcstaff = Pegawai::where([['unit_kerja', 'Logistic Controlling'], ['kode_jabatan', '5']])->get('nama');
        $wstaff = Pegawai::where([['unit_kerja', 'Warehouse'], ['kode_jabatan', '5']])->get('nama');
        $ppcstaff = Pegawai::where([['unit_kerja', 'Production Planning and Controlling'], ['kode_jabatan', '5']])->get('nama');
        $pwcstaff = Pegawai::where([['unit_kerja', 'Production Workshop Candi Sewu'], ['kode_jabatan', '5']])->get('nama');
        $pwsstaff = Pegawai::where([['unit_kerja', 'Production Workshop Sukosari'], ['kode_jabatan', '5']])->get('nama');
        $pwistaff = Pegawai::where([['unit_kerja', 'Production Workshop INKA'], ['kode_jabatan', '5']])->get('nama');
        $mstaff = Pegawai::where([['unit_kerja', 'Maintenance'], ['kode_jabatan', '5']])->get('nama');


        $purchases = Pegawai::where([['unit_kerja', 'Purchasing'], ['kode_jabatan', '5']])->get('nama');
        $expsubs = Pegawai::where([['unit_kerja', 'Expedition Sub'], ['kode_jabatan', '5']])->get('nama');
        $whcsewus = Pegawai::where([['unit_kerja', 'Warehouse Candi Sewu Sub'], ['kode_jabatan', '5']])->get('nama');
        $whsukos = Pegawai::where([['unit_kerja', 'Warehouse Sukosari Sub'], ['kode_jabatan', '5']])->get('nama');
        $ppcs = Pegawai::where([['unit_kerja', 'Production Planning and Controlling'], ['kode_jabatan', '5']])->get('nama');
        $pwcss = Pegawai::where([['unit_kerja', 'Production Workshop Candi Sewu'], ['kode_jabatan', '5']])->get('nama');
        $pwss = Pegawai::where([['unit_kerja', 'Production Workshop Sukosari'], ['kode_jabatan', '5']])->get('nama');
        $pwinkas = Pegawai::where([['unit_kerja', 'Production Workshop INKA'], ['kode_jabatan', '5']])->get('nama');
        $maintenances = Pegawai::where([['unit_kerja', 'Maintenance'], ['kode_jabatan', '5']])->get('nama');
        // return response()->json($purchasestaff);
        $dataAtasan = [
            'Organisasi', 'presdir', 'techoperationdir', 'financehrdir', 'techqualitycontroldiv', 'operationdiv', 'financediv',
            'hrga', 'eeim', 'ed', 'md', 'prodtech', 'iqc', 'ipi', 'fi', 'afsale', 'deputygm', 'purchase', 'logcontrol', 'expsub',
            'warehouse', 'whcsewu', 'whsuko', 'ppc', 'pwcs', 'pws', 'pwinka', 'maintenance', 'taxverif', 'accbud', 'tfr', 'hga', 'csl', 'it', 'bp'
        ];
        $dataStaffTOD = ['eeimstaff', 'edstaff', 'mdstaff', 'ptstaff', 'pstaff', 'lcstaff', 'wstaff', 'ppcstaff', 'pwcstaff', 'pwsstaff', 'pwistaff', 'mstaff'];
        $dataStaffHRGA = ['itstaff', 'cslstaff', 'hgastaff', 'tfrstaff', 'accbudstaff', 'taxverifstaff'];
        $dataStafffOD = ['purchases', 'expsubs', 'whcsewus', 'whsukos', 'ppcs', 'pwcss', 'pwss', 'pwinkas', 'maintenances'];

        return view('pages.DataOrganisasi.index', compact($dataAtasan, $dataStaffHRGA, $dataStaffTOD, $dataStafffOD));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $p = Pegawai::with('jabatan')
            ->whereNotIn('nama', function ($q) {
                $q->select('nama_pejabat')->from('data_organisasi');
            })
            ->get();
        $d = Division::all();
        $uk = UnitKerja::all();
        return view('pages.DataOrganisasi.create', compact('p', 'd', 'uk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_organisasi' => 'required|unique:data_organisasi,kode_organisasi',
            'nama_organisasi' => 'required',
            'nama_pejabat' => 'required',
            'level_organisasi' => 'required',
            'status' => 'required',
            'status_pejabat' => 'required',
            'jobdesk' => 'required|file|mimes:pdf,jpg,png,jpeg',
        ]);
        $file = $request->file('jobdesk');
        $identitas = $request->kode_organisasi . '-' . $request->nama_organisasi;
        $name = 'Organisasi_' . $request->kode_organisasi . '_' . $request->nama_organisasi . '_' . $this->getTanggal('date') . '.' . $file->extension();

        if (Storage::exists('public/Organisasi/' . $identitas . '/' . $name)) {
            Storage::delete('public/Organisasi/' . $identitas . '/' . $name);
        }

        $url = Storage::putFileAs('public/Organisasi/' . $identitas, $file, $name);
        $do = DataOrganisasi::create([
            'kode_organisasi' => $request->kode_organisasi,
            'nama_organisasi' => $request->nama_organisasi,
            'nama_pejabat' => $request->nama_pejabat,
            'level_organisasi' => $request->level_organisasi,
            'status' => $request->status,
            'status_pejabat' => $request->status_pejabat,
            'jobdesk' => $url,
        ]);
        if ($do) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Organisasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Organisasi = DataOrganisasi::find($id);
        // dd($Organisasi->id);
        return view('pages.DataOrganisasi.detail', compact('Organisasi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Organisasi = DataOrganisasi::find($id);
        $p = Pegawai::with('jabatan')->get();

        return view('pages.DataOrganisasi.edit', compact('Organisasi', 'p'));
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
        $request->validate([
            'kode_organisasi' => 'required|unique:data_organisasi,kode_organisasi,' . $id,
            'nama_organisasi' => 'required',
            'nama_pejabat' => 'required',
            'level_organisasi' => 'required',
            'status' => 'required',
            'status_pejabat' => 'required',
        ]);

        $data = DataOrganisasi::find($id);
        $data->kode_organisasi = $request->kode_organisasi;
        $data->nama_organisasi = $request->nama_organisasi;
        $data->nama_pejabat = $request->nama_pejabat;
        $data->level_organisasi = $request->level_organisasi;
        $data->status = $request->status;
        $data->status_pejabat = $request->status_pejabat;

        if ($request->has('jobdesk')) {
            $file = $request->file('jobdesk');
            $identitas = $request->kode_organisasi . '-' . $request->nama_organisasi;
            $name = 'Organisasi_' . $request->kode_organisasi . '_' . $request->nama_organisasi . '_' . $this->getTanggal('date') . '.' . $file->extension();

            if (Storage::exists($data->jobdesk)) {
                Storage::delete('public/Organisasi/' . $identitas . '/' . $name);
            }

            $url = Storage::putFileAs('public/Organisasi/' . $identitas, $file, $name);
            $data->jobdesk = $url;
        }
        if ($data->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Organisasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataOrganisasi::find($id)->delete();
    }

    public function export()
    {
        $nama = 'report-organisasi-' . $this->getTanggal('datetime');
        $data = DataOrganisasi::all();
        if (!empty($data[0]['id'])) {
            return Excel::download(new DataOrganisasiExport, $nama . '.xlsx');
        } else {
            alert('Data Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }

    public function import(Request $request)
    {
        if ($request->has('file')) {
            $import = Excel::import(new DataOrganisasiImport, $request->file('file'));
            if ($import) {
                alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            } else {
                alert('Simpan Data Gagal!')->background('#F4CACA');
            }
        }
        return redirect()->route('Organisasi.index');
    }

    public function getTanggal($tipe)
    {
        if ($tipe == 'date') {
            return Carbon::now()->format('d-m-Y');
        } else if ($tipe == 'datetime') {
            return Carbon::now()->format('d-m-Y-H-i-m');
        }
    }
}

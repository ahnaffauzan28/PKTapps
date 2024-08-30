<?php

namespace App\Http\Controllers;


use Log;
use Inertia\Inertia;
use App\Models\Badgeform;
use App\Models\Departeman;
use App\Models\Komparteman;
use Illuminate\Http\Request;
use Pkt\StarterKit\Helpers\DxAdapter;
use Pkt\StarterKit\Helpers\DxResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log as FacadesLog;


class Badgeformcontroller extends Controller
{
    public function showBadgeform()
    {
       
       $kompartemen = Komparteman::select('ms_komparteman_id', 'nama_kompartemen')->get();
       
     $departemen = Departeman::select('ms_departeman_id', 'nama_departemen', 'ms_komparteman_id')->get(['ms_departemen_id', 'nama_departemen', 'ms_komparteman_id']);

       return Inertia::render('BadgeForm', [
        'kompartemenOptions' => $kompartemen,
        'departemenOptions' => $departemen
    ]);

    }


    public function showrequestdata(string $id)
    {
        // return Inertia::render('Detailpemohon');
        $editbadge = Badgeform::where('tr_badgeform_id', $id)->with(['identities', 'identities.media'])->firstOrFail();
        // dd($editbadge);

    // $badgeimage = $editbadge->getAllMedia();
        return Inertia::render('Detailpemohon',[ 'editbadge' => $editbadge]);
    }

    public function submit(Request $request)
    {
        // dd($request->all());
        // Define validation rules
        $rules = [
            'email' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'nama' => 'required|string|min:4',
            'instansi' => 'required|string|max:255',
            'handphone' => 'required|string|max:15|regex:/^\+62[0-9]{9,13}$/',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string',
            'durasi' => 'required|string',
            'tanggal' => 'required|date',
            'jpemohon' => 'required|integer',
            'identities' => 'required|array',
            'identities.*.name' => 'required|string|min:5',
            'identities.*.phone' => 'required|string|max:15|regex:/^\+62[0-9]{9,13}$/',
        ];
        
        $messages = [
            'email.required' => 'Email diperlukan',
            'email.regex' => 'Email harus berakhir dengan @gmail.com',
            'nama.required' => 'Nama diperlukan',
            'nama.min' => 'Nama harus lebih dari 4 karakter',
            'handphone.required' => 'Nomor handphone diperlukan',
            'handphone.regex' => 'Nomor HP harus diawali dengan +62',
            'identities.*.name.required' => 'Nama identitas diperlukan',
            'identities.*.name.min' => 'Nama identitas harus lebih dari 4 karakter',
            'identities.*.phone.required' => 'Nomor HP identitas diperlukan',
            'identities.*.phone.regex' => 'Nomor HP harus diawali dengan +62',
        ];
        
        // Perform validation
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create Badgeform record
        $badge = Badgeform::create($request->only(['email', 'nama', 'instansi', 'handphone', 'keperluan', 'tujuan','ms_komparteman_id', 'ms_departeman_id', 'durasi', 'tanggal', 'jpemohon', 'status' ]));

        // $badge->attachMediaFromElementRequest($request->file('media_identitas'),'mediaidentitas');
        // Save identities
        foreach ($request->identities as $identitas) {
            $badge->identities()->create($identitas)->attachMediaFromElementRequest($identitas['media_identitas'],'mediaidentitas');
            // $badge->identities()->attachMediaFromElementRequest($request->file('media_identitas'),'mediaidentitas');
        }

        // Redirect with success message
        return redirect('/Badgeform')->with('message', 'Form berhasil disubmit');
    }

    public function index()
    {
        return Inertia::render('Datapemohon');
    }


    public function dataProcessing(Request $request)
{
    $user = $request->user();
    $loadData = null;

    if ($user->hasRole(['Dataadmin', 'Superadmin'])) {
        $loadData = Badgeform::with(['departemen', 'kompartemen'])->select('*');
    } elseif ($user->hasRole(['AVP'])) {
        $loadData = Badgeform::with(['departemen', 'kompartemen'])->where('status', '1')
            ->where('ms_departeman_id', $user->ms_departeman_id)
            ->select('*');
    } elseif ($user->hasRole(['VP'])) {
        $loadData = Badgeform::with(['departemen', 'kompartemen'])->where('status', '2')
        ->where('ms_departeman_id', $user->ms_departeman_id)
            ->select('*');
    } elseif ($user->hasRole(['SVPoperasi'])) {
        $loadData = Badgeform::with(['departemen', 'kompartemen'])->where('status', '3')
            ->whereIn('tujuan', [
                'Zona 1 (Pemeliharaan, Lab, Istek 1&2, Bengkel, Pabrik 1-7, PPE, Dermaga)',
                'Zona 2 (JPP, Shiping, Plant Off Site, Pertagas, KIE, Dermaga, K3)'
            ])
            ->select('*');
    } elseif ($user->hasRole(['VPkeamanan'])) {
        $loadData = Badgeform::with(['departemen', 'kompartemen'])->where('status', '4')
            ->select('*');
        
        // Jika Anda ingin memeriksa dua kondisi berbeda untuk 'VPkeamanan'
        $alternativeLoadData = Badgeform::with(['departemen', 'kompartemen'])->where('status', '3')
            ->whereIn('tujuan', [
                'Kantor Pusat (Humas, Keuangan, TJSL, PSDMO)',
                'Kaltim Daya Mandiri. PT', 
                'Kaltim Methanol Industri. PT',
                'Kaltim Parna Industri. PT'
            ])
            ->select('*');
            
        // Gabungkan kedua hasil jika diperlukan
        $loadData = $loadData->union($alternativeLoadData);
    }

    $loadDataDx = DxAdapter::load($loadData);
    return DxResponse::json($loadDataDx, $request);
}


    public function edit(string $id){
        $editbadge = Badgeform::where('tr_badgeform_id', $id)->with(['identities', 'identities.media'])->firstOrFail();
        // dd($editbadge);
        $kompartemen = Komparteman::select('ms_komparteman_id', 'nama_kompartemen')->get();
       
        $departemen = Departeman::select('ms_departeman_id', 'nama_departemen', 'ms_komparteman_id')->get(['ms_departemen_id', 'nama_departemen', 'ms_komparteman_id']);
   

    // $badgeimage = $editbadge->getAllMedia();
        return Inertia::render('Editdata',[ 
            
                'kompartemenOptions' => $kompartemen,
                'departemenOptions' => $departemen,
            'editbadge' => $editbadge
        ]);
    }


    public function update(Request $request, string $id)
{
    // Define validation rules
    // dd($request->all());
        $rules = [
            'email' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'nama' => 'required|string|min:4',
            'instansi' => 'required|string|max:255',
            'handphone' => 'required|string|max:15|regex:/^\+62[0-9]{9,13}$/',
            'keperluan' => 'required|string',
            'tujuan' => 'required|string',
            'durasi' => 'required|string',
            'tanggal' => 'required|date',
            'jpemohon' => 'required|integer',
            'identities' => 'required|array',
            'identities.*.name' => 'required|string|min:5',
            'identities.*.phone' => 'required|string|max:15|regex:/^\+62[0-9]{9,13}$/',
        ];
        
        $messages = [
            'email.required' => 'Email diperlukan',
            'email.regex' => 'Email harus berakhir dengan @gmail.com',
            'nama.required' => 'Nama diperlukan',
            'nama.min' => 'Nama harus lebih dari 4 karakter',
            'handphone.required' => 'Nomor handphone diperlukan',
            'handphone.regex' => 'Nomor HP harus diawali dengan +62',
            'identities.*.name.required' => 'Nama identitas diperlukan',
            'identities.*.name.min' => 'Nama identitas harus lebih dari 4 karakter',
            'identities.*.phone.required' => 'Nomor HP identitas diperlukan',
            'identities.*.phone.regex' => 'Nomor HP harus diawali dengan +62',
        ];
        

    // Perform validation
    $validator = Validator::make($request->all(), $rules, $messages);

    // dd($request->all());
    // If validation fails, return with errors
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Find the Badgeform record by id
    $editbadge = Badgeform::where('tr_badgeform_id', $id)->firstOrFail();

    // Update Badgeform record
    $editbadge->update($request->only(['email', 'nama', 'instansi', 'handphone', 'keperluan', 'tujuan','ms_komparteman_id', 'ms_departeman_id', 'durasi', 'tanggal', 'jpemohon','status', 'keterangan']));

    foreach ($request->identities as $identitas) {
        // Check if the 'id' key exists in the current identity array
        if (isset($identitas['id'])) {
            // Retrieve the existing identity record by ID
            $existingIdentity = $editbadge->identities()->where('tr_tambahidentitum_id', $identitas['id'])->first();
            
            // If the identity exists, update name and phone
            if ($existingIdentity) {
                $existingIdentity->update([
                    'name' => $identitas['name'],
                    'phone' => $identitas['phone'],
                ]);
    
                // Handle media_identitas separately
                $existingIdentity->syncMediaFromElementRequest($identitas['media_identitas'], 'mediaidentitas');
            }
        }
    }

    // Redirect with success message
    return redirect('/Badgeform')->with('message', 'Form berhasil diupdate');
}
    public function destroy(string $id)
{
    $badgeform = Badgeform::where('tr_badgeform_id', $id)->firstOrFail();
    
    $badgeform->delete();

    return redirect()->route('badgeform.index')->with('message', 'Form berhasil dihapus');
}

}

<?php
namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    // Afficher le profil
    public function index()
    {
        $etudiant = Etudiant::findOrFail(session('personne_id'));
        return view('etudiant.profil', compact('etudiant'));
    }

    // Modifier email, téléphone, photo
    public function modifier(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'telephone' => 'required',
        ]);

        $etudiant = Etudiant::findOrFail(session('personne_id'));
        $etudiant->email     = $request->email;
        $etudiant->telephone = $request->telephone;

        // Modifier la photo si uploadée
        if ($request->hasFile('photo')) {
            $nomPhoto = $request->file('photo')
                                ->store('photos', 'public');
            $etudiant->photo = $nomPhoto;
        }

        $etudiant->save();
        return back()->with('success', 'Profil modifié avec succès.');
    }
}
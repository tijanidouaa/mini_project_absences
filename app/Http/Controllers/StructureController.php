<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\ModulePeda;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StructureController extends Controller
{
    // ══════════════════════════════════════════════
    // FILIÈRES
    // ══════════════════════════════════════════════

    public function filieres()
    {
        $filieres     = Filiere::with('coordonnateur', 'niveaux')->get();
        $enseignants  = Enseignant::orderBy('nom_fr')->get();
        return view('structure.filieres', compact('filieres', 'enseignants'));
    }

    public function storeFiliere(Request $request)
    {
        $data = $request->validate([
            'alias'                  => 'required|string|max:20',
            'intitule'               => 'required|string|max:200',
            'annee_accreditation'    => 'required|digits:4',
            'annee_fin_accreditation'=> 'required|digits:4',
            'coordonnateur_id'       => 'nullable|exists:enseignants,id',
        ]);
        Filiere::create($data);
        return back()->with('success', 'Filière créée.');
    }

    public function updateFiliere(Request $request, Filiere $filiere)
    {
        $data = $request->validate([
            'alias'                  => 'required|string|max:20',
            'intitule'               => 'required|string|max:200',
            'annee_accreditation'    => 'required|digits:4',
            'annee_fin_accreditation'=> 'required|digits:4',
            'coordonnateur_id'       => 'nullable|exists:enseignants,id',
        ]);
        $filiere->update($data);
        return back()->with('success', 'Filière mise à jour.');
    }

    public function destroyFiliere(Filiere $filiere)
    {
        $filiere->delete();
        return back()->with('success', 'Filière supprimée.');
    }

    // ══════════════════════════════════════════════
    // NIVEAUX
    // ══════════════════════════════════════════════

    public function niveaux()
    {
        $niveaux  = Niveau::with('filiere')->get();
        $filieres = Filiere::orderBy('alias')->get();
        return view('structure.niveaux', compact('niveaux', 'filieres'));
    }

    public function storeNiveau(Request $request)
    {
        $data = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'libelle'    => 'required|string|max:100',
        ]);
        Niveau::create($data);
        return back()->with('success', 'Niveau créé.');
    }

    public function updateNiveau(Request $request, Niveau $niveau)
    {
        $data = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'libelle'    => 'required|string|max:100',
        ]);
        $niveau->update($data);
        return back()->with('success', 'Niveau mis à jour.');
    }

    public function destroyNiveau(Niveau $niveau)
    {
        $niveau->delete();
        return back()->with('success', 'Niveau supprimé.');
    }

    // ══════════════════════════════════════════════
    // MODULES PÉDAGOGIQUES
    // ══════════════════════════════════════════════

    public function modules()
    {
        $modules = ModulePeda::with('niveau.filiere', 'elements')->get();
        $niveaux = Niveau::with('filiere')->get();
        return view('structure.modules', compact('modules', 'niveaux'));
    }

    public function storeModule(Request $request)
    {
        $data = $request->validate([
            'titre'     => 'required|string|max:200',
            'code'      => 'required|string|max:50',
            'niveau_id' => 'required|exists:niveaux,id',
        ]);
        ModulePeda::create($data);
        return back()->with('success', 'Module créé.');
    }

    public function updateModule(Request $request, ModulePeda $module)
    {
        $data = $request->validate([
            'titre'     => 'required|string|max:200',
            'code'      => 'required|string|max:50',
            'niveau_id' => 'required|exists:niveaux,id',
        ]);
        $module->update($data);
        return back()->with('success', 'Module mis à jour.');
    }

    public function destroyModule(ModulePeda $module)
    {
        $module->delete();
        return back()->with('success', 'Module supprimé.');
    }

    // ══════════════════════════════════════════════
    // ÉLÉMENTS (MATIÈRES)
    // ══════════════════════════════════════════════

    public function elements()
    {
        $elements = Element::with('module.niveau.filiere')->get();
        $modules  = ModulePeda::with('niveau')->get();
        return view('structure.elements', compact('elements', 'modules'));
    }

    public function storeElement(Request $request)
    {
        $data = $request->validate([
            'titre'     => 'required|string|max:200',
            'module_id' => 'required|exists:modules,id',
        ]);
        Element::create($data);
        return back()->with('success', 'Élément créé.');
    }

    public function updateElement(Request $request, Element $element)
    {
        $data = $request->validate([
            'titre'     => 'required|string|max:200',
            'module_id' => 'required|exists:modules,id',
        ]);
        $element->update($data);
        return back()->with('success', 'Élément mis à jour.');
    }

    public function destroyElement(Element $element)
    {
        $element->delete();
        return back()->with('success', 'Élément supprimé.');
    }

    // ══════════════════════════════════════════════
    // IMPORT CSV / Excel structure pédagogique
    // ══════════════════════════════════════════════

    public function importForm()
    {
        return view('structure.import');
    }

    public function import(Request $request)
    {
        $request->validate(['fichier' => 'required|file|mimes:csv,txt']);

        $file   = $request->file('fichier');
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle); // skip header row
        $count  = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                // Format CSV attendu: filiere_alias, filiere_intitule, annee_acc, annee_fin, niveau_libelle, module_titre, module_code, element_titre
                [$filAlias, $filIntitule, $annAcc, $annFin, $nivLibelle, $modTitre, $modCode, $elemTitre] = array_pad($row, 8, null);

                $filiere = Filiere::firstOrCreate(
                    ['alias' => trim($filAlias)],
                    ['intitule' => trim($filIntitule), 'annee_accreditation' => $annAcc, 'annee_fin_accreditation' => $annFin]
                );
                $niveau = Niveau::firstOrCreate(
                    ['filiere_id' => $filiere->id, 'libelle' => trim($nivLibelle)]
                );
                if ($modTitre) {
                    $module = ModulePeda::firstOrCreate(
                        ['code' => trim($modCode), 'niveau_id' => $niveau->id],
                        ['titre' => trim($modTitre)]
                    );
                    if ($elemTitre) {
                        Element::firstOrCreate(
                            ['titre' => trim($elemTitre), 'module_id' => $module->id]
                        );
                    }
                }
                $count++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Import échoué : ' . $e->getMessage()]);
        }
        fclose($handle);

        return back()->with('success', "$count ligne(s) importée(s) avec succès.");
    }
}

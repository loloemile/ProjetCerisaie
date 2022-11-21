<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 01/10/2019
 * Time: 13:47
 */

namespace App\DAO;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use DB;
use App\metier\Utilisateur;
use  App\Exceptions\MonException;
use Illuminate\Support\Facades\Hash;

class ServiceUtilisateur
{

    /**
     * Authentifie le visiteur sur son login et Mdp
     * Si c'est OK, son id est enregistrer dans la session
     * Cela lui donne accès au menu général (voir page master)
     * @param type $login : Login du visiteur
     * @param type $pwd : MdP du visiteur
     * @return boolean : True or false
     * Le test if permet de contrôler l'injection SQL
     */
    public function login($login, $pwd) {
        $connected = false;
        try {
            $Utilisateur = DB::table('utilisateur')
                ->select()
                ->where('NomUtil', '=', $login)
                ->first();
            if ($Utilisateur) {
                if (Hash::check($pwd, $Utilisateur->MotPasse)) {
                    Session::put('id', $Utilisateur->NumUtil);
                    Session::put('role', $Utilisateur->role);
                    $connected = true;
                }
            }
        }
        catch (QueryException $e)
        {
            throw new MonException ($e->getMessage());
        }
        return $connected;
    }

    /**
     * Délogue le visiteur en mettant son Id à 0
     * dans la session => le menu n'est plus accessible
     */
    public function logout(){
        Session::put('id', 0);
        Session::put('role', 0);
    }
    public function miseAjourMotPasse($pwd) {
        try {
            DB::table('utilisateur')
                ->update(['MotPasse' => $pwd,]);
            return("modification réussite");
        } catch (QueryException $e) {
            throw new MonException($e->getMessage());
        }
    }
}

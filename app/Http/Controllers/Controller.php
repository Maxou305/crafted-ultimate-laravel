<?php

namespace App\Http\Controllers;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Crafted API",
 *     version="1.0.0",
 *     description="Cette APi permet d'accéder à toutes les fonctionnalités de l'application Crafted.",
 *     @OA\Contact(
 *         email="maxime.chazard@le-campus-numerique.fr"
 *     )
 * )
 */

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
abstract class Controller
{
    //
}

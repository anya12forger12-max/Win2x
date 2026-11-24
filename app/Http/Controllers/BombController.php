<?php namespace App\Http\Controllers;

/**
 * The Bomb game is wired into the route table and front-end but its
 * controller was never shipped. Return an explicit unavailable response
 * instead of a fatal "class not found" so routing/route:cache keeps working.
 */
class BombController extends Controller
{
    private function unavailable()
    {
        return response()->json([
            'success' => false,
            'type' => 'error',
            'msg' => 'The Bomb game is currently unavailable.'
        ], 404);
    }

    public function index() { return $this->unavailable(); }
    public function createRoom() { return $this->unavailable(); }
    public function joinGame() { return $this->unavailable(); }
}

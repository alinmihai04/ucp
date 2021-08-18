<?php

namespace App\Console\Commands;

use App\Http\Controllers\ServerController;
use App\User;
use Illuminate\Console\Command;
use DB;


class RaportProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raport:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executes automated faction raports verification for all players.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Started processing the raports.");

        $text = "Raport processing has started.";

        DB::table('raport_logs')->insert(['text'=>$text]);

        DB::table('f_members')->join('users', 'f_members.user', '=', 'users.id')->select('f_members.*', 'users.name')->orderBy('f_members.user', 'asc')->chunk(50, function ($members){
            foreach($members as $m)
            {
                if(time() >= $m->process_date)
                {
                    $raport_incomplet = false;

                    $points = DB::table('f_stats')->where('user_id', '=', $m->user)->get();

                    $goals = Cache::remember('goals' . $m->faction, 30, function() use ($m) {
                        return DB::table('f_goals')->where('group_id', '=', $m->faction)->get();
                    });

                    foreach($goals as $g)
                    {
                        if(($g->rank == $m->rank && !$m->fgroup) || $m->fgroup == $g->rank || ($m->fgroup == 14 && $g->rank == 11) || (!$g->rank))
                        {
                            if($points->isEmpty())
                            {
                                $raport_incomplet = true;
                            }
                            else
                            {
                                foreach($points as $p)
                                {
                                    if($p->type == $g->type)
                                    {
                                        if($p->current < $g->goal)
                                        {
                                            $raport_incomplet = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    DB::table('f_stats')->where('user_id', '=', $m->user)->delete();

                    Cache::forget('faction_stats' . $m->user);

                    if($raport_incomplet)
                    {
                        if($m->rank == 1)
                        {
                            User::uninvitePlayer($m->user, 'AdmBot', 'incomplete faction raport.', 40);
                            email($m->user, "Raportul tau de activitate a fost incomplet. Ai primit uninvite cu 40 FP.", '#');
                        }
                        else
                        {
                            DB::table('f_members')->where('user', '=', $m->user)->update(['process_date' => strtotime('+7 days')]);

                            email($m->user, "Raportul tau de activitate a fost incomplet.", '#');
                        }
                    }
                    else
                    {
                        if(time() >= $m->rankup_date && $m->rank < 5)
                        {
                            $rank = $m->rank + 1;
                            $nextrank = strtotime('+7 days -1 hour');

                            if($rank == 2)
                            {
                                $nextrank = strtotime('+14 days -1 hour');
                            }

                            DB::table('f_members')->where('user', '=', $m->user)->update(['rankup_date' => $nextrank, 'rank' => $rank,'process_date' => strtotime('+7 days -1 hour')]);
                            DB::table('users')->where('id', '=', $m->user)->update(['user_grouprank' => $rank]);

                            ServerController::sendPanelAction($m->user, 5, $rank, $m->faction, $m->name . " completed his faction activity raport. His rank was changed from " . $m->rank . " to " . $rank . ".");
                            email($m->user, "Your rank was modified from " . $m->rank . " to " . $rank . " (auto).", '#');
                        }
                        else
                        {
                            DB::table('f_members')->where('user', '=', $m->user)->update(['process_date' => strtotime('+7 days -1 hour')]);

                            email($m->user, "Raportul tau de activitate a fost complet. Nu ai primit rank up.", '#');

                            ServerController::sendPanelAction($m->user, 5, 0, $m->faction, $m->name . " completed his faction activity raport. His rank was not changed.");
                        }
                    }
                }
            }
        });

        $text = "Raport processing has ended.";
        DB::table('raport_logs')->insert(['text'=>$text]);
    }
}

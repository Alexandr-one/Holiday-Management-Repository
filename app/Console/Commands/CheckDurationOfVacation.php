<?php

namespace App\Console\Commands;

use App\Application;
use App\Classes\ApplicationStatusEnum;
use App\Classes\ControlOrganizationEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckDurationOfVacation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check duration of vacation';

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
        $organization = Organization::findOrFail(ControlOrganizationEnum::ID);
        $users = User::where('status',UserStatusEnum::EMPLOYEE)->get();
        $admins = User::where('status',UserStatusEnum::ADMIN)->get();
        $groupByDate = [];
        foreach($users as $user) {
            $applications = Application::where("status",ApplicationStatusEnum::CONFIRMED)->where('user_id',$user->id)->get();
            foreach($applications as $application){
                $years = Carbon::createFromFormat('Y-m-d', $application->date_start)->year;
                if ($years >= Carbon::now()->year) {
                $groupByDate[$years][] = $application;
               }
            }
            foreach($groupByDate as $key => $value){
                $numberDays = 0;
                foreach ($value as $item){
                    $numberDays += $item->number_of_days;
                }
                if ($numberDays < $organization->min_duration_of_vacation) {
                    foreach ($admins as $admin){
                        $email = $admin->email;
                        $posts = "У пользователя ".$user->email.' суммарная длительность отпуска за '.$key." год (".$numberDays." дней) меньше минимальной (".$organization->min_duration_of_vacation." дней).";
                        $name = "Holiday Management System";
                        $title = "Уведомление";
                        Mail::raw($posts,function($message) use ($email,$name,$title){
                            $message->to($email , 'To web dev blog')->subject($title);
                            $message->from('2004sasharyzhakov@gmail.com',$name);
                        });
                    }
                    $email = $user->email;
                    $posts = "У вас суммарная длительность отпуска за ".$key." год (".$numberDays." дней) меньше минимальной (".$organization->min_duration_of_vacation." дней).";
                    $name = "Holiday Management System";
                    $title = "Уведомление";
                    Mail::raw($posts,function($message) use ($email,$name,$title){
                        $message->to($email , 'To web dev blog')->subject($title);
                        $message->from('2004sasharyzhakov@gmail.com',$name);
                    });
                }
            }
        }
    }
}

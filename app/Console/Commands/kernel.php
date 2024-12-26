protected function schedule(Schedule $schedule) {
    $schedule->command('notify:upcoming-tasks')->daily();
}

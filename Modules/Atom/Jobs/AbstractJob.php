<?php namespace Modules\Atom\Jobs;

abstract class AbstractJob implements \Illuminate\Contracts\Queue\ShouldQueue {

    use
        \Illuminate\Queue\SerializesModels ,
        \Illuminate\Foundation\Bus\Dispatchable ,
        \Illuminate\Queue\InteractsWithQueue ,
        \Illuminate\Bus\Queueable
    ;
}
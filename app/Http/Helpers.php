<?php

    function static_asset($path, $secure = null){
            return app('url')->asset('public/' . $path,$secure);
    }
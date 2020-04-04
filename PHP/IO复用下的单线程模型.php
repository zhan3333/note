<?php

$reactor = new Reactor();
$svrSock = stream_socket_server('tcp://127.0.0.1:9501');
$reactor->add($svrSock, EV_READ, function () use ($svrSock, $reactor) {
    $cliSock = stream_socket_accept($svrSock);
    $reactor->add($cliSock, EV_READ, function () use ($cliSock, $reactor) {
        $request = fread($cliSock, 8192);
        $reactor->add($cliSock, EV_WRITE, function () use ($cliSock, $request, $reactor) {
            fwrite($cliSock, "hello world \n");
            $reactor->del($cliSock);
            fclose($cliSock);
        });
    });
});
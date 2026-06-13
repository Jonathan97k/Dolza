<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::create('/api/team', 'GET'));
echo "Status: " . $response->getStatusCode() . "\n";
echo "Content: " . substr($response->getContent(), 0, 500) . "\n";
echo "Testimonials:\n";
$res2 = $kernel->handle(Illuminate\Http\Request::create('/api/testimonials', 'GET'));
echo "Status: " . $res2->getStatusCode() . "\n";
echo "Content: " . substr($res2->getContent(), 0, 500) . "\n";
echo "Content:\n";
$res3 = $kernel->handle(Illuminate\Http\Request::create('/api/content', 'GET'));
echo "Status: " . $res3->getStatusCode() . "\n";
echo "Content: " . substr($res3->getContent(), 0, 500) . "\n";

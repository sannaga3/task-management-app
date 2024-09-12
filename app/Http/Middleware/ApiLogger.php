<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    private $guard;
    private $actionName;

    public function __construct(Request $request)
    {
        $this->guard = $request->is('api/*') ? 'api' : 'web';

        $route = $request->route();
        $this->actionName = $route ? $route->getActionName() : 'No Action';
    }

    public function handle(Request $request, Closure $next)
    {
        // リクエスト等をログ出力
        $user = Auth::user();
        $user_id = empty($user) ? 'unAuthorized' : $user->id;
        Log::channel('custom')->info(
            "\nstart logging\n" .
                "-----------------------------------------------------------\n" .
                "request\n" .
                "guard: " . $this->guard . "\n" .
                "method: " . $request->method() . "\n" .
                "url: " . $request->fullUrl() . "\n" .
                "request params: " . json_encode($request->all(), JSON_PRETTY_PRINT) . "\n" .
                "action: " . $this->actionName . "\n" .
                "user_id: " . $user_id
        );

        // リクエストを次の処理に渡す
        $res = $next($request);

        // レスポンスの準備
        $content = $res->getContent();
        $responseContent = null;

        // responseのログは5種類(サーバーエラー、例外処理、画面遷移、画面リロード、APIレスポンス)
        // エラーがある場合はログ出力して終了
        $decodedContent = json_decode($content, true);
        [$hasError, $responseContent, $errors] = $this->checkErrors($res, $decodedContent);
        if ($hasError) {
            Log::channel('custom')->warning($responseContent);
            Log::channel('custom')->info($errors);
            Log::channel('custom')->info(
                "\n-----------------------------------------------------------\nend logging\n"
            );
            return $res;
        };

        // Guard毎にレスポンスの中身を作成
        if ($this->guard === 'web') {
            $responseContent = $this->makeResponseContentWeb($decodedContent);
        } else if ($this->guard === 'api') {
            $responseContent = json_encode($decodedContent, JSON_PRETTY_PRINT);
        }

        // レスポンスの出力
        $this->makeResponseLog($res, $responseContent);
        return $res;
    }

    /*
        エラーチェック
    */
    public function checkErrors($res, $decodedContent)
    {
        if (isset($decodedContent['exception']) || isset($decodedContent['errors'])) {
            $errors = $decodedContent['errors'] ?? $decodedContent;
            // traceは文字数が多い為省く
            if (isset($errors['trace'])) unset($errors['trace']);

            $errorContent = "\n" .
                "error response\n" .
                "guard: " . $this->guard . "\n" .
                "status: " . $res->status() . "\n" .
                "errors: ⬇︎";

            return [true, $errorContent, $errors];
        }

        return [false, null, null];
    }

    /*
        レスポンスログの中身作成（webガード）
    */
    public function makeResponseContentWeb($decodedContent)
    {
        if (isset($decodedContent['props'])) {
            // 通常の画面遷移
            return json_encode($decodedContent['props'], JSON_PRETTY_PRINT);
        } else {
            // 画面側でリロードした場合（レスポンスがhtml）
            return 'HTML Response';
        }
    }

    /*
        レスポンスログ出力
    */
    public function makeResponseLog($res, $content)
    {
        Log::channel('custom')->info(
            "\nresponse\n" .
                "guard: " . $this->guard . "\n" .
                "status: " . $res->status() . "\n" .
                "content: " . $content .
                "\n-----------------------------------------------------------\n" .
                "end logging\n"
        );
    }
}
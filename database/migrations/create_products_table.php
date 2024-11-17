public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->integer('stock');
        $table->string('category_id');
        $table->string('image_url')->nullable();
        $table->timestamps();
    });
}


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        $client_id = env('MERCADO_LIVRE_CLIENT_ID');
        $redirect_uri = env('MERCADO_LIVRE_REDIRECT_URI');
        $url = "https://auth.mercadolivre.com.br/authorization?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri";
        
        return redirect($url);
    }

    public function handleProviderCallback(Request $request)
    {
        $client_id = env('MERCADO_LIVRE_CLIENT_ID');
        $client_secret = env('MERCADO_LIVRE_CLIENT_SECRET');
        $redirect_uri = env('MERCADO_LIVRE_REDIRECT_URI');
        
        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $request->code,
            'redirect_uri' => $redirect_uri,
        ]);
        
        $data = $response->json();
        
        session(['access_token' => $data['access_token']]);
        
        return redirect()->route('product.create');
    }
}


use App\Http\Controllers\AuthController;

Route::get('oauth/redirect', [AuthController::class, 'redirectToProvider']);
Route::get('oauth/callback', [AuthController::class, 'handleProviderCallback'])
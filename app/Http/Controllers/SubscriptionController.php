<?php
//use Illuminate\Support\Facades\Mail;

/*namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
}
*/
// routes/web.php
//Route::post('/subscribe', 'SubscriptionController@subscribe')->name('subscribe');

// app/Http/Controllers/SubscriptionController.php
namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
//use App\Models\Subscription;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;


class SubscriptionController extends Controller
{
    public function subscribe(Request $request, $category)
    {     //subscribe method, you can check the category of the subscription and
        // create a new subscription record in the corresponding table
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:'.$category.'_subscriptions,email',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, create a new subscription record in the database
        $subscription = new Subscription;
        $subscription = new $category;
        $subscription->name = $request->name;
        $subscription->email = $request->email;
        $subscription->save();

        // Send a welcome email to the subscriber
        Mail::to($request->email)->send(new SubscriptionConfirmation($request->email));

        // Redirect back to the homepage with a success message
        return redirect('/')->with('success', 'You have successfully subscribed! '.$category.'!');
    }
}

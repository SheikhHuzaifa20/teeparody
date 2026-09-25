<?php

namespace App\Http\Controllers;

use App\Mail\AdminInquiryMail;
use App\Mail\UserInquiryConfirmationMail;
use Illuminate\Http\Request;
use App\schedule;
use App\newsletter;
use App\post;
use App\Models\Inquiry;
use App\banner;
use App\imagetable;
use DB;
use Mail;
use View;
use Session;
use App\Http\Helpers\UserSystemInfoHelper;
use App\Http\Traits\HelperTrait;
use Auth;
use App\Profile;
use App\Page;
use Image;

class HomeController extends Controller
{
    use HelperTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // use Helper;

    public function __construct()
    {
        //$this->middleware('auth');

        $logo = imagetable::select('img_path')
            ->where('table_name', '=', 'logo')
            ->first();

        $favicon = imagetable::select('img_path')
            ->where('table_name', '=', 'favicon')
            ->first();

        View()->share('logo', $logo);
        View()->share('favicon', $favicon);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = DB::table('pages')->where('id', 1)->first();
        $section = DB::table('sections')->where('page_id', 1)->get();
        $banner = DB::table('banners')->where('id', 1)->where('status', 1)->first();
        $product = DB::table('products')
            ->where('status', 1)
            ->get();

        foreach ($product as $item) {
            // Product Images
            $item->product_images = DB::table('product_images')
                ->where('product_id', $item->id)
                ->get();

            // Product Attributes
            $item->attributes = DB::table('product_attributes')
                ->leftJoin(
                    'attributes',
                    'attributes.id',
                    '=',
                    'product_attributes.attribute_id'
                )
                ->leftJoin(
                    'attributes_values',
                    'attributes_values.id',
                    '=',
                    'product_attributes.value'
                )
                ->where('product_attributes.product_id', $item->id)
                ->select(
                    'product_attributes.*',
                    'attributes.name as attribute_name',
                    'attributes_values.value as attribute_value_name'
                )
                ->get();
        }

        return view('welcome', compact('page', 'banner', 'section', 'product'));
    }

    public function about()
    {
        $page = DB::table('pages')->where('id', 2)->first();
        $banner = DB::table('banners')->where('id', 3)->where('status', 1)->first();


        return view('about', compact('page', 'banner'));
    }

    public function product(Request $request)
    {
        $page = DB::table('pages')->where('id', 1)->first();
        $section = DB::table('sections')->where('page_id', 1)->first();
        $banner = DB::table('banners')->where('id', 2)->where('status', 1)->first();

        $query = DB::table('products')->where('status', 1);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $product = $query->get();

        foreach ($product as $item) {
            // Product Images
            $item->product_images = DB::table('product_images')
                ->where('product_id', $item->id)
                ->get();

            // Product Attributes
            $item->attributes = DB::table('product_attributes')
                ->leftJoin(
                    'attributes',
                    'attributes.id',
                    '=',
                    'product_attributes.attribute_id'
                )
                ->leftJoin(
                    'attributes_values',
                    'attributes_values.id',
                    '=',
                    'product_attributes.value'
                )
                ->where('product_attributes.product_id', $item->id)
                ->select(
                    'product_attributes.*',
                    'attributes.name as attribute_name',
                    'attributes_values.value as attribute_value_name'
                )
                ->get();
        }


        return view('products', compact('page', 'banner', 'section', 'product'));
    }

    public function product_detail($id)
    {
        // Product
        $product = DB::table('products')
            ->where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$product) {
            abort(404);
        }

        // Product Images
        $product->images = DB::table('product_images')
            ->where('product_id', $product->id)
            ->get();

        // Product Attributes
        $product->attributes = DB::table('product_attributes')
            ->leftJoin(
                'attributes',
                'attributes.id',
                '=',
                'product_attributes.attribute_id'
            )
            ->leftJoin(
                'attributes_values',
                'attributes_values.id',
                '=',
                'product_attributes.value'
            )
            ->where('product_attributes.product_id', $product->id)
            ->select(
                'product_attributes.*',
                'attributes.name as attribute_name',
                'attributes_values.value as attribute_value_name'
            )
            ->get();

        return view('product_detail', compact('product'));
    }

    public function services()
    {
        $page = DB::table('pages')->where('id', 3)->first();
        $section = DB::table('sections')->where('page_id', 3)->get();
        $banner = DB::table('banners')->where('id', 4)->where('status', 1)->first();
        $product = DB::table('products')
            ->where('status', 1)
            ->get();

        foreach ($product as $item) {

            // Product Images
            $item->product_images = DB::table('product_images')
                ->where('product_id', $item->id)
                ->get();

            // Product Attributes
            // $item->product_attributes = DB::table('product_attributes')
            //     ->where('product_id', $item->id)
            //     ->get();
        }

        return view('services', compact('page', 'banner', 'section', 'product'));
    }

    public function contact()
    {
        $page = DB::table('pages')->where('id', 4)->first();
        $section = DB::table('sections')->where('page_id', 4)->get();
        $banner = DB::table('banners')->where('id', 5)->where('status', 1)->first();

        return view('contact', compact('page', 'banner', 'section'));
    }

    public function return_policy()
    {
        $page = DB::table('pages')->where('id', 6)->first();

        return view('shipping-and-return-policy', compact('page'));
    }

    public function terms_conditions()
    {
        $page = DB::table('pages')->where('id', 7)->first();

        return view('terms-and-conditions', compact('page'));
    }

    public function privacy_policy()
    {
        $page = DB::table('pages')->where('id', 8)->first();

        return view('privacy-policy', compact('page'));
    }

    public function careerSubmit(Request $request)
    {


        inquiry::create($request->all());


        return response()->json(['message' => 'Thank you for contacting us. We will get back to you asap', 'status' => true]);
        return back();
    }

    public function newsletterSubmit(Request $request)
    {

        $is_email = newsletter::where('newsletter_email', $request->newsletter_email)->count();
        if ($is_email == 0) {
            $inquiry = new newsletter;
            $inquiry->newsletter_email = $request->newsletter_email;
            $inquiry->save();
            return response()->json(['message' => 'Thank you for contacting us. We will get back to you asap', 'status' => true]);
        } else {
            return response()->json(['message' => 'Email already exists', 'status' => false]);
        }
    }

    public function updateContent(Request $request)
    {
        $id = $request->input('id');
        $keyword = $request->input('keyword');
        $htmlContent = $request->input('htmlContent');
        if ($keyword == 'page') {
            $update = DB::table('pages')
                ->where('id', $id)
                ->update(array('content' => $htmlContent));

            if ($update) {
                return response()->json(['message' => 'Content Updated Successfully', 'status' => true]);
            } else {
                return response()->json(['message' => 'Error Occurred', 'status' => false]);
            }
        } else if ($keyword == 'section') {
            $update = DB::table('section')
                ->where('id', $id)
                ->update(array('value' => $htmlContent));
            if ($update) {
                return response()->json(['message' => 'Content Updated Successfully', 'status' => true]);
            } else {
                return response()->json(['message' => 'Error Occurred', 'status' => false]);
            }
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'form_name' => 'Contact',
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        // Admin ko inquiry
        Mail::to(config('mail.admin_email'))
            ->send(new AdminInquiryMail($inquiry));

        // Customer ko confirmation
        Mail::to($inquiry->email)
            ->send(new UserInquiryConfirmationMail($inquiry));

        return back()->with(
            'message',
            'Your message has been sent successfully!'
        );
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\CentralLogics\Helpers;
use App\CentralLogics\ProductLogic;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\Category;
use App\Model\Product;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct(
        private User $user,
    ) {}
    /**
     * @return Application|Factory|View
     */
    public function home(): Factory|View|Application
    {
        $bannerPrimer = Banner::where('status', 1)->where('banner_type', 'primary')->get();
        $bannerSecandary = Banner::where('status', 1)->where('banner_type', 'secondary')->get();
        $categories = Category::where(['position' => 0, 'status' => 1])->get();
        $featuredCategoryList = Category::active()->where('is_featured', 1)->get();
        $featuredData = [];
        foreach ($featuredCategoryList as $category) {
            $products = Product::active()->whereJsonContains('category_ids', ['id' => (string)$category->id])->take(15)->get();
            if ($products->count() > 0) {
                $featuredData[] = [
                    'category' => $category,
                    'products' => Helpers::product_data_formatting($products, true)
                ];
            }
        }
        $latestProducts = ProductLogic::get_latest_products('created_at');
        $latestProducts['products'] = Helpers::product_data_formatting($latestProducts['products'], true);
        return view('frontend.home', compact('bannerPrimer', 'bannerSecandary', 'categories', 'featuredData', 'latestProducts'));
    }

    /**
     * @return Application|Factory|View
     */
    public function store(Request $request): Factory|View|Application
    {
        $categories = Category::where(['position' => 0, 'status' => 1])->get();
        foreach ($categories as $category) {
            $category['products_count'] = Product::whereJsonContains('category_ids', ['id' => (string)$category['id']])->count();
            $category['sub_categories'] = Category::where('parent_id',  $category->id)->where('status', 1)->get();
        }
        $min_price = Product::min('price');
        $max_price = Product::max('price');
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;
        $search = $request->search;
        return view('frontend.store', compact('categories', 'min_price', 'max_price', 'category_id', 'sub_category_id', 'search'));
    }
    public function filter(Request $request): JsonResponse
    {
        $offset = isset($request->offset) ? $request->offset : 0;
        $limit = isset($request->limit) ? $request->limit : 10;
        $property = Product::where('status', 1);
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $order = $request->order;
        if (isset($category_id)) {
            $property = $property->whereJsonContains('category_ids', ['id' => (string)$category_id]);
        }
        if (isset($sub_category_id)) {
            $property = $property->whereJsonContains('category_ids', ['id' => (string)$sub_category_id]);
        }
        if (isset($min_price)) {
            $property = $property->where('price', '>=', $min_price);
        }
        if (isset($max_price)) {
            $property = $property->where('price', '<=', $max_price);
        }
        if (isset($request->search) && !empty($request->search)) {
            $search = $request->search;
            $property = $property->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            });
        }
        if (isset($order)) {
            if ($order == 1) {
                $property = $property->orderBy('created_at', 'desc');
            } elseif ($order == 2) {
                $property = $property->orderBy('created_at');
            } elseif ($order == 3) {
                $property = $property->orderBy('price', 'desc');
            } elseif ($order == 4) {
                $property = $property->orderBy('price');
            } elseif ($order == 5) {
                $property = $property->orderBy('discount', 'desc');
            } elseif ($order == 6) {
                $property = $property->orderBy('discount');
            }
        }
        $total = $property->get()->count();
        $result = $property->skip($offset)->take($limit)->get();
        if (!$result->isEmpty()) {
            $response['error'] = false;
            $response['message'] = "Data Fetch Successfully";
            $response['total'] = $total;
            $response['offset'] = $offset;
            $response['limit'] = $limit;
            $response['data'] = $result;
        } else {
            $response['error'] = true;
            $response['total'] = $total;
            $response['offset'] = $offset;
            $response['limit'] = $limit;
            $response['message'] = "No data found!";
            $response['data'] = [];
        }
        return response()->json($response);
    }

    /**
     * @return Application|Factory|View
     */
    public function product($id): Factory|View|Application
    {
        $product = ProductLogic::get_product($id);
        $product = Helpers::product_data_formatting($product, false);
        $categoryId = $product['category_ids'];
        foreach ($product['category_ids'] as $categoryIds) {
            if ($categoryIds->position == 1) {
                $categoryId = $categoryIds->id;
            }
        }
        $products = Product::active()->get();
        $productIds = [];
        foreach ($products as $pro) {
            foreach (json_decode($pro['category_ids'], true) as $category) {
                if ($category['id'] == $categoryId) {
                    $productIds[] = $pro['id'];
                }
            }
        }
        $relatedProducts = Product::active()
            ->with('rating')
            ->withCount(['wishlist'])
            ->whereIn('id', $productIds)
            ->whereNot('id', $id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $relatedProducts = Helpers::product_data_formatting($relatedProducts, true);
        return view('frontend.product', compact('product', 'relatedProducts'));
    }
    /**
     * @return Application|Factory|View
     */
    public function dashboard(): Factory|View|Application
    {
        $data = 1;
        return view('frontend.home', compact('data'));
    }

    public function settingsUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'f_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ], [
            'f_name.required' => 'First name is required!',
        ]);

        $admin =  $this->user->find(auth('web')->id());
        $admin->f_name = $request->f_name;
        $admin->l_name = $request->l_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        // $admin->image = $request->has('images') ? Helpers::update('admin/', $admin->image, 'png', $request->file('image')) : $admin->image;
        $admin->save();
        Toastr::success(translate('Admin updated successfully!'));
        return back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function settingsPasswordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);
        $admin =  $this->user->find(auth(guard: 'web')->id());
        $admin->password = bcrypt($request['password']);
        $admin->save();
        Toastr::success(translate('Admin password updated successfully!'));
        return back();
    }
}

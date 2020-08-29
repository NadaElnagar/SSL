<?php


namespace Modules\HomePage\Http\Repository;


use App\Http\Repository\BaseRepository;
use Modules\HomePage\Entities\CollectionProduct;
use Modules\HomePage\Entities\HPCollection;
use Modules\HomePage\Entities\HPSubject;
use Modules\HomePage\Entities\Collection;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\productPrice;
use DB;
class HPCollectionRepository
{
    public function index($request)
    {
        $collection = (new Collection())->newQuery();
        $collection->with('collectionText')->with('product');
        $collection_repository = (new BaseRepository())->paginationRepository($request, $collection);
        $result['count'] = $collection_repository['count'];
        $result['collection'] = $collection_repository['data'];
        return $result;
    }

    public function show($id)
    {
        return Collection::with('collectionText')->with('product')->find($id);
    }

    public function store($data)
    {
        $collection = new Collection();
        if ($collection->save()) {
            $collection_id = $collection->id;
            $text = json_decode(json_encode($data['text']), true);
            $this->saveText($text, $collection_id);
            $this->saveCollectionProductId($data['product_id'], $collection_id);
            return true;
        } else {
            return false;
        }
    }

    private function saveText($text, $collection_id)
    {
        foreach ($text as $collection_product) {
            $product = new HPCollection();
            $product->text = $collection_product['text'];
            $product->lang = $collection_product['lang'];
            $product->collection_id = $collection_id;
            $product->save();
        }
    }

    private function saveCollectionProductId($products, $collection_id)
    {
        foreach ($products as $product_id) {
            $product = new CollectionProduct();
            $product->collection_id = $collection_id;
            $product->product_id = $product_id;
            $product->save();
        }
        return true;
    }

    public function delete($id)
    {
        Collection::where('id', $id)->delete();
        $collection = CollectionProduct::where('collection_id', $id)->delete();
        return HPCollection::where('collection_id', $id)->delete();
    }

    public function update($id, $data)
    {
        if (Collection::find($id)) {
            if (isset($data['product_id'])) {
                CollectionProduct::where('collection_id', $id)->delete();
                $this->saveCollectionProductId($data['product_id'], $id);
            }
            if (isset($data['text'])) {
                if (HPCollection::where('collection_id', $id)->delete()) {
                    $this->saveText($data['text'], $id);
                }
            }
            return $this->show($id);
        } else {
            return false;
        }
    }

    public function frontListCollection($lang)

    {
        $result = array();
        $language = get_language($lang);
        $collection = HPCollection::where('lang', $language->id)->get();
        if ($collection) {
            foreach ($collection as $main_collection) {

                $products = DB::table('collection_product')
                    ->join('product','product.id','collection_product.product_id')
                    ->where('collection_id', $main_collection['collection_id'])
                    ->select('product.id', 'product.product_name')
                    ->get();

                foreach ($products as $product) {
                    $product->price = productPrice::where('product_id', $product->id)
                        ->select('id','number_of_months','price','admin_price','product_id')->first();
                }
                $main_collection['product'] = $products;
                $result[] = $main_collection;
            }
            return $result;
        }
        return false;
    }
}

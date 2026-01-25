<?php

namespace App\Services;

use App\Models\Product;
use App\Models\TransactionDetail;
use App\Models\TransactionMaster;
use App\Models\TransactionType;
use DateTime;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function create(TransactionType $type, array $data): TransactionMaster
    {
        return DB::transaction(function () use ($type, $data) {
            $transactionMaster = TransactionMaster::create([
                'transaction_type_id' => $type->id,
                'transaction_date' => now()
            ]);

            foreach ($data['items'] as $item) {
                $productId = $item['productId'];
                $productPrice = $item['productPrice'];
                $qty = $item['qty'];

                TransactionDetail::create([
                    'transaction_master_id' => $transactionMaster->id,
                    'product_id' => $productId,
                    'price' => $productPrice,
                    'qty' => $qty,
                ]);

                $this->adjustProductStock(
                    $productId,
                    $qty,
                    $type->is_decreasing
                );
            }

            return $transactionMaster;
        });
    }


    private function adjustProductStock(int $productId, int $qty, bool $isDecrease)
    {
        $product = Product::findOrFail($productId);

        if ($isDecrease) {
            $product->product_stock -= $qty;
        } else {
            $product->product_stock += $qty;
        }

        $product->save();
    }
}

<?php

namespace App\Http\Services;


use App\Models\Property;
use App\Models\PropertyTenant;
use App\Models\PropertyTransaction;
use App\Models\PropertyUserTransaction;
use App\Models\TransactionCategory;
use App\Models\TransactionRecurring;
use App\Models\TransactionType;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    protected $request;

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }

    public function getTransactionCategories()
    {
        return [
            'status' => 1,
            'data' => TransactionCategory::orderBy('user_id', 'asc')->orderBy('weight',
                'desc')->get()
        ];
    }

    public function getTransactionTypes()
    {
        return [
            'status' => 1,
            'data' => TransactionType::get()
        ];
    }

    public function getTransactionRecurrings()
    {
        return [
            'status' => 1,
            'data' => TransactionRecurring::orderBy('weight', 'desc')->get()
        ];
    }

    public function getPropertyTransaction($id)
    {
        $transactions = PropertyTransaction::where('property_id', $id)->whereNull('user_id')->with('transactionCategory',
            'transactionRecurring',
            'unit')
            ->get();
        return [
            'status' => 1,
            'data' => $transactions,
        ];
    }

    public function getUserTransactionByProperty($userId, $propertyId)
    {
        $propertyTenant = PropertyTenant::where('user_id', $userId)->where('property_id', $propertyId)->first();
        return $this->getUserTransactionByPropertyTenant($propertyTenant);
    }

    public function getUserTransactionByPropertyTenant($propertyTenant)
    {
        if (!is_object($propertyTenant)) {
            $propertyTenant = PropertyTenant::where('user_id', $propertyTenant)->first();
        }
        $transactions = [];
        if ($propertyTenant) {
            if ($propertyTenant) {
                $transactions = \DB::table('property_transactions')
                    ->select(\DB::raw('
            property_user_transactions.id as property_user_transactions_id,
            property_user_transactions.amount,
            property_user_transactions.user_id,
            properties.unit,
            property_transactions.amount_total,
            property_transactions.unit_id,
            property_transactions.id,
            property_transactions.description,
            property_transactions.user_id as property_transactions_user_id,
            property_transactions.transaction_category_id,
            property_transactions.transaction_recurring_id,
            transaction_categories.title as transaction_categories_title,
            transaction_recurrings.title as transaction_recurrings_title
            '))
                    ->leftJoin('property_user_transactions', function (JoinClause $join) {
                        $join->on('property_user_transactions.property_transaction_id', '=',
                            'property_transactions.id')
                            ->whereNull('property_user_transactions.deleted_at');
                    })
                    ->leftJoin('properties', function ($join) {
                        $join->on('properties.id', '=', 'property_transactions.unit_id');
                    })
                    ->leftJoin('transaction_categories', 'property_transactions.transaction_category_id', '=',
                        'transaction_categories.id')
                    ->leftJoin('transaction_recurrings', 'property_transactions.transaction_recurring_id', '=',
                        'transaction_recurrings.id')
                    ->whereRaw('property_transactions.property_id="' . $propertyTenant->property_id . '"
            and (property_transactions.user_id IS NULL OR property_transactions.user_id="' . $propertyTenant->user_id . '")
            and (property_transactions.unit_id IS NULL OR property_transactions.unit_id=' . (int)$propertyTenant->unit_id . ')
            ')
                    ->whereNull('property_transactions.deleted_at')
//                    ->groupBy('property_transactions.id')
                    ->get();
            }
        }
        return [
            'status' => 1,
            'data' => $transactions
        ];
    }

    public function saveTransaction()
    {
        $transactionData = $this->request->all();
        $property = null;
        if (!$property) {
            if (!$transactionData['property_id']) {
                return ['status' => 0];
            } else {
                $property = Property::where('id', $transactionData['property_id'])->where('user_id',
                    Auth::user()->id)->get(['id'])->first();
                if (!$property) {
                    return ['status' => 0];
                }
            }
        }
        if ($property && $property['id'] != $transactionData['property_id']) {
            return ['status' => 0];
        }
        if (isset($transactionData['id']) && $transactionData['id']) {
            $transaction = PropertyTransaction::where('id', $transactionData['id'])->first();
        } else {
            $transaction = new PropertyTransaction();
        }
        $transactionData['amount'] = isset($transactionData['amount']) ? round($transactionData['amount'],
            2) : null;
        $transactionData['amount_tax'] = (int)$transactionData['amount_tax'] ?: null;
        if (!$transactionData['amount']) {
            $transactionData['amount_total'] = null;
        }
        $fill = [
            'property_id' => $transactionData['property_id'],
            'unit_id' => $transactionData['unit_id'],
            'description' => $transactionData['description'],
            'amount' => $transactionData['amount'],
            'amount_tax' => $transactionData['amount_tax'],
            'amount_total' => $transactionData['amount_total'],
            'amount_tax_included' => $transactionData['amount_tax_included'],
            'transaction_category_id' => $transactionData['transaction_category_id'],
            'transaction_recurring_id' => $transactionData['transaction_recurring_id']
        ];
        $transaction->fill($fill);
        if ($transaction->validate() && $transaction->save()) {
            $transaction = PropertyTransaction::where('id', $transaction->id)->with('transactionCategory',
                'transactionRecurring',
                'unit')
                ->first();
            if (isset($transactionData['index'])) {
                $transaction->index = $transactionData['index'];
            }
            return [
                'status' => 1,
                'data' => $transaction
            ];
        }

        return [
            'status' => (isset($transaction['errors']) && $transaction['errors']) ? 0 : 1,
            'data' => $transactionData
        ];
    }

    public function saveUserTransaction()
    {
        $userTransactionRequest = $this->request->all();
        $transaction = null;
        $userTransactionData = $userTransactionRequest['model'];
        $propertyTenant = PropertyTenant::where('property_tenants.id', (int)$userTransactionRequest['id'])
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'property_tenants.user_id')
                    ->where('users.parent_id', '=', Auth::user()->id);
            })
            ->first();
        if ($propertyTenant) {
            $propertyTransaction = PropertyTransaction::where('id',
                $userTransactionData['id'])->first();
            if ($propertyTransaction) {
                if (isset($userTransactionData['property_transactions_user_id'])) {
                    $propertyTransaction->description = $userTransactionData['description'];
                    $propertyTransaction->transaction_recurring_id = $userTransactionData['transaction_recurring_id'];
                    $propertyTransaction->amount_total = $userTransactionData['amount'];
                    $propertyTransaction->save();
                }
            } else {
                $propertyTransaction = new PropertyTransaction();
                $propertyTransaction->user_id = $propertyTenant->user_id;
                $propertyTransaction->unit_id = $propertyTenant->unit_id;
                $propertyTransaction->property_id = $propertyTenant->property_id;
                $propertyTransaction->amount = $userTransactionData['amount'];
                $propertyTransaction->amount_total = $userTransactionData['amount'];
                $propertyTransaction->description = $userTransactionData['description'];
                $propertyTransaction->transaction_recurring_id = $userTransactionData['transaction_recurring_id'];
                $propertyTransaction->save();
            }
            if (isset($userTransactionData['property_user_transactions_id']) && $userTransactionData['property_user_transactions_id']) {
                $propertyUserTransaction = PropertyUserTransaction::where('id',
                    $userTransactionData['property_user_transactions_id'])->first();
            } else {
                $propertyUserTransaction = new PropertyUserTransaction();
                $propertyUserTransaction->transaction_type_id = 1;
                $propertyUserTransaction->user_id = $propertyTenant->user_id;
                $propertyUserTransaction->property_transaction_id = $propertyTransaction->id;
            }
            $propertyUserTransaction->amount = $userTransactionData['amount'];
            $propertyUserTransaction->save();
            //
            $transaction = \DB::table('property_transactions')
                ->select(\DB::raw('
            property_user_transactions.id as property_user_transactions_id,
            property_user_transactions.amount,
            property_user_transactions.user_id,
            properties.unit,
            property_transactions.amount_total,
            property_transactions.unit_id,
            property_transactions.id,
            property_transactions.description,
            property_transactions.user_id as property_transactions_user_id,
            property_transactions.transaction_category_id,
            property_transactions.transaction_recurring_id,
            transaction_categories.title as transaction_categories_title,
            transaction_recurrings.title as transaction_recurrings_title
            '))
                ->join('property_user_transactions', function ($join) use ($propertyUserTransaction) {
                    $join->on('property_user_transactions.property_transaction_id', '=', 'property_transactions.id')
                        ->where('property_user_transactions.id', '=', $propertyUserTransaction->id)
                        ->whereNull('property_user_transactions.deleted_at');
                })
                ->leftJoin('properties', function ($join) {
                    $join->on('properties.id', '=', 'property_transactions.unit_id');
                })
                ->leftJoin('transaction_categories', 'property_transactions.transaction_category_id', '=',
                    'transaction_categories.id')
                ->leftJoin('transaction_recurrings', 'property_transactions.transaction_recurring_id', '=',
                    'transaction_recurrings.id')
                ->where('property_transactions.id', $propertyTransaction->id)
                ->whereNull('property_transactions.deleted_at')
                ->first();

        }
        if (isset($userTransactionData['index'])) {
            $transaction->index = $userTransactionData['index'];
        }
        return [
            'status' => 1,
            'data' => $transaction
        ];
    }

    public function deleteTransaction($id)
    {
        $transaction = PropertyTransaction::where('property_transactions.id', (int)$id)
            ->join('properties', 'property_transactions.property_id', '=', 'properties.id')
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'properties.user_id')
                    ->where('users.parent_id', '=', \Auth::user()->id)
                    ->orWhere('users.id', '=', Auth::user()->id);
            })
            ->exists();
        if ($transaction) {
            PropertyTransaction::where('id', (int)$id)->delete();
            return ['status' => 1];
        }
        return ['status' => 0];
    }

    public function deleteUserTransaction($transactionId)
    {
        if (PropertyUserTransaction::where('id',
            $transactionId)->delete()
        ) {
            return ['status' => 1];
        }
        return ['status' => 0];
    }

}

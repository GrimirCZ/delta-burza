<?php

namespace App\Http\Livewire;

use App\Exports\PaymentResultExport;
use App\Imports\PaymentImport;
use App\Jobs\GenerateInvoice;
use App\Jobs\GenerateProformaInvoice;
use App\Models\Order;
use App\Models\OrderRegistration;
use Aws\ImportExport\Exception\ImportExportException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ProcessPayments extends Component
{
    use WithFileUploads;

    public $platby;
    public $output = null;
    public $filepath = null;
    public $error = null;

    protected $rules = [
        'platby' => 'required|file|max:5120'
    ];

    public function mount()
    {
        if(!Auth::user()->is_admin){
            return abort(401);
        }
    }

    public function submit()
    {
        $this->error = null;

        $amount_key = "castka";
        $vs_key = "variabilni_symbolreference";

        DB::transaction(function() use ($amount_key, $vs_key){
            try{

                $this->validate();

                $s3 = Storage::disk("private_s3");
                $upload_name = "imports/" . uniqid() . "_" . $this->platby->getClientOriginalName();

//                $file_path = $this->platby->store($upload_name, "private_s3");
                $s3->put($upload_name, $this->platby->get());
//                dd($upload_name, $file_path);

                // parse csv
                $rows = (new PaymentImport())->toCollection($upload_name, "private_s3", \Maatwebsite\Excel\Excel::CSV)[0]; // why is there a nested collection?
                Storage::disk("private_s3")->delete($upload_name);

                for($i = 0; $i < $rows->count(); $i++){
                    $row = $rows[$i];

                    if($row[$amount_key] == null){
                        $rows[$i]->put("chyba", "Chybí částka ($amount_key)");
                        $rows[$i]->put("stav", "selhání");
                        continue;
                    }

                    $num_fmt = numfmt_create('cs', \NumberFormatter::DECIMAL);
                    $castka = numfmt_parse($num_fmt, trim($row[$amount_key]));

                    if($row[$vs_key] == null){
                        $rows[$i]->put("chyba", "Chybí variabilní symbol ($vs_key)");
                        $rows[$i]->put("stav", "selhání");
                        continue;
                    }

                    $vs = trim($row[$vs_key]);

                    $or = Order::where("proforma_invoice_number", $vs)->first();

                    if($or == null){
                        $rows[$i]->put("popis", "Nebyla nalezena shoda pro číslo proforma faktury: $vs");
                        $rows[$i]->put("stav", "selhání");
                        continue;
                    }

                    if($or->price() != $castka){
                        $rows[$i]->put("popis", "Částka se neshoduje, předpokládaná částka: {$or->price()}, skutečná částka: {$castka}");
                        $rows[$i]->put("stav", "selhání");
                        continue;
                    }

                    if($or->invoice != null){ // do not process orders twice
                        $rows[$i]->put("popis", "Tato platba už byla zpracováná, žádná akce nebyla provedena");
                        $rows[$i]->put("stav", "Duplicitní platba");
                        continue;
                    }

                    OrderRegistration::where("order_id", $or->id)->update([
                        'fulfilled_at' => DB::raw("CURRENT_TIMESTAMP"),
                    ]);

                    GenerateInvoice::dispatch($or->id);

                    $rows[$i]->put("popis", "Platba byla zpracována a email odeslán");
                    $rows[$i]->put("stav", "úspěch");
                }


                $this->filepath = "/invoice_export_result/" . uniqid() . ".csv";

                $export = new PaymentResultExport($rows);
                Excel::store($export, $this->filepath, "private_s3", \Maatwebsite\Excel\Excel::CSV);

                $this->output = $this->filepath;
            } catch(Exception $e){
                $this->error = $e->getMessage();
            }
        });
    }

    public function delete_results()
    {
        try{
            $s3 = Storage::disk("private_s3");
            $s3->delete($this->filepath);

            $this->output = null;
            $this->error = null;
        } catch(Exception $e){
            $this->error = $e->getMessage();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.process-payments');
    }
}

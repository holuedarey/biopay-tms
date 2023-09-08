<?php

namespace App\Http\Livewire;

use App\Enums\Status;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class Statistics extends Component
{
    public ?User $user;
    public ?string $period = null;
    public ?string $previous = null;
    public string|array|null $date_range = null;

    public function mount(): void
    {
        if (is_null($this->date_range)) {
            if ($this->period == 'all') $this->period = '';

            else $this->period ??= 'today';
        }
        else {
            $this->date_range = str($this->date_range)->explode(' - ')->toArray();
        }
    }

    public function render()
    {
        $services = is_null($this->date_range) ? $this->getPeriodStats() : $this->getDateRangeStats();

        $services = $services->sortBy(fn($s) => $s->slug !== 'cashoutwithdrawal');

        $transactions = $this->getResponseCodeStats();

        return view('livewire.statistics', compact('services', 'transactions'));
    }

    /**
     * @return Collection<Service>
     */
    private function getPeriodStats(): Collection
    {
        $services = Service::regular()->transactionCount($this->period, $this->user)->get();

        return $services->map(function ($service) {
            $service->previous_failed ??= 0;
            $service->previous_successful ??= 0;
            $service->total_trans = $service->failed + $service->successful;
            $service->previous_total = $service->previous_failed + $service->previous_successful;

            $highest_total = max([$service->total_trans, $service->previous_total]);
            $total_percent = $highest_total != 0 ? (($service->total_trans - $service->previous_total) / $highest_total) * 100 : 0;

            $highest_failed = max([$service->previous_failed, $service->failed]);
            $failed_percent = $highest_failed != 0 ? (($service->failed - $service->previous_failed) / $highest_failed) * 100 : 0;

            $highest_success = max([$service->previous_successful, $service->successful]);
            $success_percent = $highest_success != 0 ? (($service->successful - $service->previous_successful) / $highest_success) * 100 : 0;

            $service->total_percent = round($total_percent);
            $service->success_percent = round($failed_percent);
            $service->failed_percent = round($success_percent);

            return $service;
        });
    }

    /**
     * @return Collection<Service>
     */
    private function getDateRangeStats(): Collection
    {
        $services = Service::regular()->withCount([
            'transactions as failed' => fn($query) => $query->whereStatus(Status::FAILED)
                ->filterByDate($this->date_range)
                ->when($this->user ?? false)->forUser($this->user),
            'transactions as successful' => fn($query) => $query->whereStatus(Status::SUCCESSFUL)
                ->filterByDate($this->date_range)
                ->when($this->user ?? false)->forUser($this->user),
        ])->get();

        return $services->map(function ($service) {
            $service->total_trans = $service->failed + $service->successful;
            $service->total_percent = 0;
            $service->success_percent = 0;
            $service->failed_percent = 0;

            return $service;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<Transaction>
     */
    private function getResponseCodeStats(): \Illuminate\Database\Eloquent\Collection
    {
        return Transaction::whereRelation('service', 'slug', 'cashoutwithdrawal')
            ->when($this->user ?? false)->forUser($this->user)
            ->when(is_null($this->date_range),
                fn($query) => $query->filterByDateDesc($this->period),
                fn($query) => $query->filterByDate($this->date_range),
            )->whereNotNull('response_code')
            ->groupBy('response_code')
            ->selectRaw('response_code, count(*) as count')
            ->orderBy('response_code')->get();
    }
}

<?php

namespace App\Http\Resources;

use App\Services\AppService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->notifiable, $this->getType($this->type));
        $formatted = $this->formatter();

        return [
            'id' => $this->id,
            'notifiable' => [
                'name' => $this->notifiable->name,
                'email' => $this->notifiable->email,
            ],
            'type' => data_get($formatted, 'type'),
            'message' => data_get($formatted, 'message'),
            'link' => data_get($formatted, 'link'),
            'icon' => data_get($formatted, 'icon'),
            'created_at' => (new AppService)->dateFormatter($this->created_at),
        ];
    }

    private function formatter(): array
    {
        $type = "";
        $link = "";
        $icon = "";
        $message = "";

        if ($this->type == 'App\\Notifications\\CardRequestNotification') {
            
            $type = __('Card request');  
            $message = __('There is a card request');
            $icon = 'tabler:credit-card-pay';
            $link = route('card-requests.index');

        } else if ($this->type == 'App\\Notifications\\CardRequestProcessNotification') {
            
            $type = __('Card request process');
            $message = __('Your card request has been :status', ['status' => data_get($this->data, 'card_request_status')]);
            $icon = 'mingcute:card-pay-line';
            $link = '#';

        } else if ($this->type == 'App\\Notifications\\CardTopupRequestNotification') {
            
            $type = __('Card topup request');
            $message = __('There is a card topup request');
            $icon = 'mynaui:credit-card-plus';
            $link = '#';

        }

        return [
            'type' => $type,
            'link' => $link,
            'icon' => $icon,
            'message' => $message,
        ];

    }
}

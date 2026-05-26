<?php

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentSubmitted extends Notification
{
    use Queueable;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // mail + database notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Dokumen masuk ke Review1')
                    ->line('Dokumen "' . $this->document->title . '" telah disubmit ke Review1.')
                    ->action('Lihat Dokumen', url('/documents/'.$this->document->id))
                    ->line('Silakan lakukan review.');
    }

    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'title' => $this->document->title,
            'creator_id' => $this->document->creator_id,
        ];
    }
}

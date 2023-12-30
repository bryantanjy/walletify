<?php

namespace App\Mail;

use App\Models\ExpenseSharingGroup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $group;
    public $token;
    public $acceptUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(ExpenseSharingGroup $group, $token, $acceptUrl)
    {
        $this->group = $group;
        $this->token = $token;
        $this->acceptUrl = $acceptUrl;
    }

    public function build()
    {
        return $this->markdown('emails.group-invitation')
            ->with([
                'group' => $this->group,
                'token' => $this->token,
                'acceptUrl' => $this->acceptUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Group Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.group-invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

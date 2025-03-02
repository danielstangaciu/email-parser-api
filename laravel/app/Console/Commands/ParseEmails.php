<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseEmails extends Command
{
    protected $signature = 'emails:parse';
    protected $description = 'Parse raw email content to extract plain text and update the database';

    public function handle()
    {
        $emails = DB::table('successful_emails')
            ->where('raw_text', '')
            ->limit(50) // process in batches
            ->get();

        foreach ($emails as $email) {
            $plainText = $this->extractPlainText($email->email);
            DB::table('successful_emails')
                ->where('id', $email->id)
                ->update(['raw_text' => $plainText]);
            $this->info("Processed email ID: {$email->id}");
        }
    }

    public function extractPlainText($emailRawContent)
    {
        // Split headers and body
        $parts = preg_split("/\r?\n\r?\n/", $emailRawContent, 2);
        $body = $parts[1] ?? '';

        // Strip HTML tags and normalize whitespace and line breaks
        $plainText = strip_tags($body);
        $plainText = preg_replace('/\s+/', ' ', $plainText);
        $plainText = trim($plainText);
        $plainText = str_replace(["\r", "\n "], ["\n", "\n"], $plainText);

        return $plainText;
    }
}

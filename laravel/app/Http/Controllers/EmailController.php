<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    // Create a new record and automatically parse the email
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            // Validate additional fields as necessary
        ]);

        // Use the command's method to extract plain text
        $data['raw_text'] = (new \App\Console\Commands\ParseEmails)->extractPlainText($data['email']);

        $id = DB::table('successful_emails')->insertGetId($data);

        return response()->json(['id' => $id, 'raw_text' => $data['raw_text']]);
    }

    // Fetch a single record by ID
    public function getById($id)
    {
        $email = DB::table('successful_emails')->where('id', $id)->first();
        return response()->json($email);
    }

    // Update a record based on the ID passed
    public function update(Request $request, $id)
    {
        $data = $request->only(['email']);
        if (isset($data['email'])) {
            $data['raw_text'] = (new \App\Console\Commands\ParseEmails)->extractPlainText($data['email']);
        }
        DB::table('successful_emails')->where('id', $id)->update($data);
        return response()->json(['message' => 'Record updated successfully']);
    }

    // Return all records excluding soft-deleted items
    public function getAll()
    {
        $emails = DB::table('successful_emails')->whereNull('deleted_at')->get();
        return response()->json($emails);
    }

    // Soft delete a record based on the ID passed
    public function deleteById($id)
    {
        DB::table('successful_emails')->where('id', $id)->update(['deleted_at' => now()]);
        return response()->json(['message' => 'Record soft deleted']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PanelService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\QuoteService;
use InvalidArgumentException;

class PanelController extends Controller
{
    protected PanelService $panelService;

    public function __construct(PanelService $panelService)
    {
        $this->panelService = $panelService;
    }

    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'quotes');
        $search = $request->query('search');

        return view('admin.panel', $this->panelService->getDashboardData($tab, $search));
    }

    public function bulkStore(Request $request, QuoteService $quoteService)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json,txt|max:2048',
        ]);

        try {
            $importedCount = $quoteService->importFromJsonFile($request->file('json_file'));
        } catch (InvalidArgumentException $e) {
            return back()->withErrors(['json_file' => $e->getMessage()]);
        }

        return redirect()
            ->route('admin.panel', ['tab' => 'quotes'])
            ->with('success', "Importação concluída! {$importedCount} citações foram adicionadas com sucesso.");
    }
}
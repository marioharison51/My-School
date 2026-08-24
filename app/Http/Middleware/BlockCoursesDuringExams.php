<?php

namespace App\Http\Middleware;

use App\Models\ExamPeriod;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockCoursesDuringExams
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $role = $user->role instanceof \App\Enums\Role ? $user->role->value : $user->role;

        // Seuls élèves et parents sont concernés par le masquage
        if (in_array($role, ['eleve', 'parent'], true) && ExamPeriod::isCurrentlyActive()) {
            abort(403, "Veuillez contacter la direction ou l'admin pour avoir accès à cette rubrique.");
        }

        return $next($request);
    }
}

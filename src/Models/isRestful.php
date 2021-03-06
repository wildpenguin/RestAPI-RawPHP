<?php 
/**
 * Provide common interface for all Models 
 */

namespace API\Models;

interface isRestful 
{
    public function view($request);
    public function create($request, $data);
    public function update($request, $data);
    public function delete($request);
    public function viewAll($request);
}

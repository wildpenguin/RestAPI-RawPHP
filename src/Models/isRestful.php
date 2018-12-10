<?php 
/**
 * Provide common interface for all Models 
 */

namespace API\Models;

interface isRestful 
{
    public function view($id);
    public function create($data);
    public function update($request, $data);
    public function delete($request);
    public function viewAll();
}

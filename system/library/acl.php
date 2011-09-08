<?php if(!defined('SWAMI')){die('External Access to File Denied');}

/**
 * Access Control List Library Main Class For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/acl-library
 */

class acl
{
	private static $acls = array();
	
	
	// Create ACL
	// ---------------------------------------------------------------------------
	public static function create($name)
	{
		self::$acls[$name] = new aclResource();
		return self::$acls[$name];
	}
	
	
	// Get ACL
	// ---------------------------------------------------------------------------
	public static function get($name)
	{
		if(isset(self::$acls[$name]))	return self::$acls[$name];
		else return false;
	}
}


/**
 * Access Control List Library ACL Class For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */
class aclResource
{
	private $roles = array();
	private $resources = array();
	
	// Add Role
	// ---------------------------------------------------------------------------
	public function role($role,$parents=array())
	{
		$this->roles[$role] = $parents;
		return $this;
	}
	
	// Add Resource
	// ---------------------------------------------------------------------------
	public function resource($res,$allow=array(),$deny=array())
	{
		$this->resources[$res] = array('allow'=>$allow,'deny'=>$deny);
		return $this;
	}
	
	// Allow Resource
	// ---------------------------------------------------------------------------
	public function allow($role,$res)
	{
		// If resource exists - add role
		if(isset($this->resources[$res]))
			$this->resources[$res]['allow'][] = $role;
		return $this;
	}
	
	// Deny Resource
	// ---------------------------------------------------------------------------
	public function deny($role,$res)
	{
		// If resource exists - add role
		if(isset($this->resources[$res]))	
			$this->resources[$res]['deny'][] = $role;
		return $this;
	}
	
	// Is Allowed
	// ---------------------------------------------------------------------------
	public function isAllowed($role,$res)
	{
		$tmp = $this->parentsAllowed($role,$res);
		
		if(isset($this->resources[$res]['deny'])&&in_array($role,$this->resources[$res]['deny']))
		{
			$tmp = FALSE;
		}
		elseif(isset($this->resources[$res]['allow'])&&in_array($role,$this->resources[$res]['allow']) OR $tmp == TRUE)
		{
			$tmp = TRUE;
		}
		else
		{
			$tmp = FALSE;
		}
		
		return $tmp;
	}
	
	// Parents Allowed (Recursive)
	// ---------------------------------------------------------------------------
	public function parentsAllowed($role,$res)
	{
		$tmp = FALSE;
	
		if(isset($this->roles[$role]))
		{
			foreach($this->roles[$role] as $parent)
			{
				if(isset($this->resources[$res]['deny'])&&in_array($parent,$this->resources[$res]['deny']))
				{
					$tmp = FALSE;
				}
				elseif(isset($this->resources[$res]['allow'])&&in_array($parent,$this->resources[$res]['allow']))
				{
					$tmp = TRUE;
				}
				else
				{
					$tmp = $this->parentsAllowed($parent,$res);
				}
			}
		}
		
		return $tmp;
	}
}

<?php
/**
 *  Kateglo: Kamus, Tesaurus dan Glosarium bahasa Indonesia.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the GPL 2.0. For more information, see
 * <http://code.google.com/p/kateglo/>.
 *
 * @license <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html> GPL 2.0
 * @link    http://code.google.com/p/kateglo/
 * @copyright Copyright (c) 2009 Kateglo (http://code.google.com/p/kateglo/)
 */
namespace Momoku\Ioc\Provider;

use net\stubbles\ioc\InjectionProvider;
use net\stubbles\lang\BaseObject;
use Doctrine\Common\Annotations;

/**
 *
 * @author  Arthur Purnama <arthur@purnama.de>
 */
class AnnotationReader extends BaseObject implements InjectionProvider
{

    /**
     * @var array
     */
    private $configuration;

    /**
     * Constructor
     *
     * @Inject
     * @Named('ApplicationConfiguration')
     * @param $configuration Application Configuration
     */
    public function __construct($configuration)
    {
        $this->configuration = $configuration['annotation'];
    }

    /**
     * returns the value to provide
     *
     * @param   string $name
     * @return  \Doctrine\Common\Annotations\Reader
     */
    public function get($name = null)
    {
        foreach ($this->configuration['namespaces'] as $namespace => $path) {
            Annotations\AnnotationRegistry::registerAutoloadNamespace($namespace, $path);
        }
        //return new Annotations\AnnotationReader();
        return new Annotations\FileCacheReader(new Annotations\AnnotationReader(),
            $this->configuration['cache']['path'],
            $_SERVER['APPLICATION_ENV'] === 'development'
        );
    }
}

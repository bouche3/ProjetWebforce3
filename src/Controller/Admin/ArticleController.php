<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\SearchArticleType;
use App\Entity\ImageTemplate;
use App\Entity\MixteTemplate;
use App\Entity\TextTemplate;
use App\Form\TemplateImageType;
use App\Form\TemplateMixteType;
use App\Form\TemplateTextType;
use App\Form\TemplateType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ArticleController
 * @package App\Controller\Admin
 *
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     * @param ArticleRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $repository, Request $request)
    {

        $searchForm = $this->createForm(SearchArticleType::class);

        $searchForm->handleRequest($request);

        $articles = $repository->search((array)$searchForm->getData());

        return $this->render(
            'admin/article/index.html.twig',
            [
                'articles' => $articles,
                'search_form' => $searchForm->createView(),
            ]
        );
    }

    /**
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function addEditArticle(Request $request, EntityManagerInterface $manager, $id)
    {

        if (is_null($id)) {
            $article = new Article();
            $article->setUserid($this->getUser());
        } else {
            $article = $manager->find(Article::class, $id);

            if (is_null($article)) {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(TemplateType::class, $article);
        $form->handleRequest($request);

        dump($article);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $manager->persist($article);
                $manager->flush();
                dump($article);

                if ($article->getNameTemplate()->getId() == 1) {
                    return $this->redirectToRoute(
                        'app_admin_article_addeditarticleimage',
                        [
                            'id' => $article->getId()
                        ]
                    );
                } elseif ($article->getNameTemplate()->getId() == 2) {
                    return $this->redirectToRoute(
                        'app_admin_article_addeditarticletext',
                        [
                            'id' => $article->getId()
                        ]
                    );
                } elseif ($article->getNameTemplate()->getId() == 3) {
                    return $this->redirectToRoute(
                        'app_admin_article_addeditarticlemixte',
                        [
                            'id' => $article->getId()
                        ]
                    );
                }

            }
        }

        return $this->render(
            'admin/article/add_edit_article.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/edition/m/{id}", requirements={"id": "\d+"})
     */
    public function addEditArticleMixte(Request $request, EntityManagerInterface $manager, Article $article)
    {
        $originalBanner = null;
        $originalImg1 = null;
        $originalImg2 = null;
        $originalCarouselImg1 = null;
        $originalCarouselImg2 = null;
        $originalCarouselImg3 = null;
        $originalCarouselImg4 = null;
        $originalCarouselImg5 = null;
        $template = $article->getTemplateMixedid();

        if (is_null($template)) {
            $template = new MixteTemplate();
            $article->setTemplateMixedid($template);
        } else {

            if (!is_null($template->getBanner())) {
                $originalBanner = $template->getBanner();

                $template->setBanner(
                    new File($this->getParameter('upload_dir') . $template->getBanner())
                );
            }
            if (!is_null($template->getImg1())) {
                $originalImg1 = $template->getImg1();

                $template->setImg1(
                    new File($this->getParameter('upload_dir') . $template->getImg1())
                );
            }
            if (!is_null($template->getImg2())) {
                $originalImg2 = $template->getImg2();

                $template->setImg2(
                    new File($this->getParameter('upload_dir') . $template->getImg2())
                );
            }
            if (!is_null($template->getCarouselImg1())) {
                $originalCarouselImg1 = $template->getCarouselImg1();

                $template->setCarouselImg1(
                    new File($this->getParameter('upload_dir') . $template->getCarouselImg1())
                );
            }
            if (!is_null($template->getCarouselImg2())) {
                $originalCarouselImg2 = $template->getCarouselImg2();

                $template->setCarouselImg2(
                    new File($this->getParameter('upload_dir') . $template->getCarouselImg2())
                );
            }
            if (!is_null($template->getCarouselImg3())) {
                $originalCarouselImg3 = $template->getCarouselImg3();

                $template->setCarouselImg3(
                    new File($this->getParameter('upload_dir') . $template->getCarouselImg3())
                );
            }
            if (!is_null($template->getCarouselImg4())) {
                $originalCarouselImg4 = $template->getCarouselImg4();

                $template->setCarouselImg4(
                    new File($this->getParameter('upload_dir') . $template->getCarouselImg4())
                );
            }
            if (!is_null($template->getCarouselImg5())) {
                $originalCarouselImg5 = $template->getCarouselImg5();

                $template->setCarouselImg5(
                    new File($this->getParameter('upload_dir') . $template->getCarouselImg5())
                );
            }
        }

        $form = $this->createForm(TemplateMixteType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /** @var UploadedFile|null $banner */
                /** @var UploadedFile|null $img1 */
                /** @var UploadedFile|null $img2 */
                /** @var UploadedFile|null $CarouselImg1 */
                /** @var UploadedFile|null $CarouselImg2 */
                /** @var UploadedFile|null $CarouselImg3 */
                /** @var UploadedFile|null $CarouselImg4 */
                /** @var UploadedFile|null $CarouselImg5 */
                $banner = $template->getBanner();
                $img1 = $template->getImg1();
                $img2 = $template->getImg2();
                $CarouselImg1 = $template->getCarouselImg1();
                $CarouselImg2 = $template->getCarouselImg2();
                $CarouselImg3 = $template->getCarouselImg3();
                $CarouselImg4 = $template->getCarouselImg4();
                $CarouselImg5 = $template->getCarouselImg5();

                if (!is_null($banner)) {

                    $filename = uniqid() . '.' . $banner->guessExtension();

                    $banner->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setBanner($filename);

                    if (!is_null($originalBanner)) {
                        unlink($this->getParameter('upload_dir') . $originalBanner);
                    }
                } else {
                    $template->setBanner($originalBanner);
                }

                if (!is_null($img1)) {

                    $filename = uniqid() . '.' . $img1->guessExtension();

                    $img1->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg1($filename);

                    if (!is_null($originalImg1)) {
                        unlink($this->getParameter('upload_dir') . $originalImg1);
                    }
                } else {
                    $template->setImg1($originalImg1);
                }

                if (!is_null($img2)) {

                    $filename = uniqid() . '.' . $img2->guessExtension();

                    $img2->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg2($filename);

                    if (!is_null($originalImg2)) {
                        unlink($this->getParameter('upload_dir') . $originalImg2);
                    }
                } else {
                    $template->setImg2($originalImg2);
                }

                if (!is_null($CarouselImg1)) {

                    $filename = uniqid() . '.' . $CarouselImg1->guessExtension();

                    $CarouselImg1->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setCarouselImg1($filename);

                    if (!is_null($originalCarouselImg1)) {
                        unlink($this->getParameter('upload_dir') . $originalCarouselImg1);
                    }
                } else {
                    $template->setCarouselImg1($originalCarouselImg1);
                }

                if (!is_null($CarouselImg2)) {

                    $filename = uniqid() . '.' . $CarouselImg2->guessExtension();

                    $CarouselImg2->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setCarouselImg2($filename);

                    if (!is_null($originalCarouselImg2)) {
                        unlink($this->getParameter('upload_dir') . $originalCarouselImg2);
                    }
                } else {
                    $template->setCarouselImg2($originalCarouselImg2);
                }

                if (!is_null($CarouselImg3)) {

                    $filename = uniqid() . '.' . $CarouselImg3->guessExtension();

                    $CarouselImg3->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setCarouselImg3($filename);

                    if (!is_null($originalCarouselImg3)) {
                        unlink($this->getParameter('upload_dir') . $originalCarouselImg3);
                    }
                } else {
                    $template->setCarouselImg3($originalCarouselImg3);
                }

                if (!is_null($CarouselImg4)) {

                    $filename = uniqid() . '.' . $CarouselImg4->guessExtension();

                    $CarouselImg4->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setCarouselImg4($filename);

                    if (!is_null($originalCarouselImg4)) {
                        unlink($this->getParameter('upload_dir') . $originalCarouselImg4);
                    }
                } else {
                    $template->setCarouselImg4($originalCarouselImg4);
                }

                if (!is_null($CarouselImg5)) {

                    $filename = uniqid() . '.' . $CarouselImg5->guessExtension();

                    $CarouselImg5->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setCarouselImg5($filename);

                    if (!is_null($originalCarouselImg5)) {
                        unlink($this->getParameter('upload_dir') . $originalCarouselImg5);
                    }
                } else {
                    $template->setCarouselImg5($originalCarouselImg5);
                }

                $manager->persist($template);
                $manager->flush();
                dump($template);

                return $this->redirectToRoute(
                    'app_admin_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            }
        }

        return $this->render(
            'admin/article/render_m_article.html.twig',
            [
                'form' => $form->createView(),
                'original_banner' => $originalBanner,
                'original_image1' => $originalImg1,
                'original_image2' => $originalImg2,
                'original_carousel_image_1' => $originalCarouselImg1,
                'original_carousel_image_2' => $originalCarouselImg2,
                'original_carousel_image_3' => $originalCarouselImg3,
                'original_carousel_image_4' => $originalCarouselImg4,
                'original_carousel_image_5' => $originalCarouselImg5
            ]
        );
    }

    /**
     * @Route("/edition/t/{id}", requirements={"id": "\d+"})
     */
    public function addEditArticleText(Request $request, EntityManagerInterface $manager, Article $article)
    {
        $originalBanner = null;
        $originalImg1 = null;
        $originalImg2 = null;
        $template = $article->getTemplateTextid();

        if (is_null($template)) {
            $template = new TextTemplate();
            $article->setTemplateTextid($template);
        } else {

            if (!is_null($template->getBanner())) {
                $originalBanner = $template->getBanner();

                $template->setBanner(
                    new File($this->getParameter('upload_dir') . $template->getBanner())
                );
            }
            if (!is_null($template->getImg1())) {
                $originalImg1 = $template->getImg1();

                $template->setImg1(
                    new File($this->getParameter('upload_dir') . $template->getImg1())
                );
            }
            if (!is_null($template->getImg2())) {
                $originalImg2 = $template->getImg2();

                $template->setImg2(
                    new File($this->getParameter('upload_dir') . $template->getImg2())
                );
            }
        }

        $form = $this->createForm(TemplateTextType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /** @var UploadedFile|null $banner */
                /** @var UploadedFile|null $img1 */
                /** @var UploadedFile|null $img2 */
                $banner = $template->getBanner();
                $img1 = $template->getImg1();
                $img2 = $template->getImg2();

                if (!is_null($banner)) {

                    $filename = uniqid() . '.' . $banner->guessExtension();

                    $banner->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setBanner($filename);

                    if (!is_null($originalBanner)) {
                        unlink($this->getParameter('upload_dir') . $originalBanner);
                    }
                } else {
                    $template->setBanner($originalBanner);
                }

                if (!is_null($img1)) {

                    $filename = uniqid() . '.' . $img1->guessExtension();

                    $img1->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg1($filename);

                    if (!is_null($originalImg1)) {
                        unlink($this->getParameter('upload_dir') . $originalImg1);
                    }
                } else {
                    $template->setImg1($originalImg1);
                }

                if (!is_null($img2)) {

                    $filename = uniqid() . '.' . $img2->guessExtension();

                    $img2->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg2($filename);

                    if (!is_null($originalImg2)) {
                        unlink($this->getParameter('upload_dir') . $originalImg2);
                    }
                } else {
                    $template->setImg2($originalImg2);
                }

                $manager->persist($template);
                $manager->flush();
                dump($template);

                return $this->redirectToRoute(
                    'app_admin_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            }
        }

        return $this->render(
            'admin/article/render_t_article.html.twig',
            [
                'form' => $form->createView(),
                'original_banner' => $originalBanner,
                'original_image1' => $originalImg1,
                'original_image2' => $originalImg2
            ]
        );
    }

    /**
     * @Route("/edition/i/{id}", requirements={"id": "\d+"})
     */
    public function addEditArticleImage(EntityManagerInterface $manager, Article $article, Request $request)
    {
        $originalBanner = null;
        $originalImg1 = null;
        $originalImg2 = null;
        $originalImg3 = null;
        $originalImg4 = null;
        $originalImg5 = null;
        $originalImg6 = null;
        $originalImg7 = null;
        $originalImg8 = null;
        $originalImg9 = null;
        $originalImg10 = null;
        $originalImg11 = null;
        $originalImg12 = null;
        $template = $article->getTemplateImageid();

        if (is_null($template)) {
            $template = new ImageTemplate();
            $article->setTemplateImageid($template);
        } else {

            if (!is_null($template->getBanner())) {
                $originalBanner = $template->getBanner();

                $template->setBanner(
                    new File($this->getParameter('upload_dir') . $template->getBanner())
                );
            }
            if (!is_null($template->getImg1())) {
                $originalImg1 = $template->getImg1();

                $template->setImg1(
                    new File($this->getParameter('upload_dir') . $template->getImg1())
                );
            }
            if (!is_null($template->getImg2())) {
                $originalImg2 = $template->getImg2();

                $template->setImg2(
                    new File($this->getParameter('upload_dir') . $template->getImg2())
                );
            }
            if (!is_null($template->getImg3())) {
                $originalImg3 = $template->getImg3();

                $template->setImg3(
                    new File($this->getParameter('upload_dir') . $template->getImg3())
                );
            }
            if (!is_null($template->getImg4())) {
                $originalImg4 = $template->getImg4();

                $template->setImg4(
                    new File($this->getParameter('upload_dir') . $template->getImg4())
                );
            }
            if (!is_null($template->getImg5())) {
                $originalImg5 = $template->getImg5();

                $template->setImg5(
                    new File($this->getParameter('upload_dir') . $template->getImg5())
                );
            }
            if (!is_null($template->getImg6())) {
                $originalImg6 = $template->getImg6();

                $template->setImg6(
                    new File($this->getParameter('upload_dir') . $template->getImg6())
                );
            }
            if (!is_null($template->getImg7())) {
                $originalImg7 = $template->getImg7();

                $template->setImg7(
                    new File($this->getParameter('upload_dir') . $template->getImg7())
                );
            }
            if (!is_null($template->getImg8())) {
                $originalImg8 = $template->getImg8();

                $template->setImg8(
                    new File($this->getParameter('upload_dir') . $template->getImg8())
                );
            }
            if (!is_null($template->getImg9())) {
                $originalImg9 = $template->getImg9();

                $template->setImg9(
                    new File($this->getParameter('upload_dir') . $template->getImg9())
                );
            }
            if (!is_null($template->getImg10())) {
                $originalImg10 = $template->getImg10();

                $template->setImg10(
                    new File($this->getParameter('upload_dir') . $template->getImg10())
                );
            }
            if (!is_null($template->getImg11())) {
                $originalImg11 = $template->getImg11();

                $template->setImg11(
                    new File($this->getParameter('upload_dir') . $template->getImg11())
                );
            }
            if (!is_null($template->getImg12())) {
                $originalImg12 = $template->getImg12();

                $template->setImg12(
                    new File($this->getParameter('upload_dir') . $template->getImg12())
                );
            }
            dump($template);
        }

        $form = $this->createForm(TemplateImageType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                /** @var UploadedFile|null $banner */
                /** @var UploadedFile|null $img1 */
                /** @var UploadedFile|null $img2 */
                /** @var UploadedFile|null $img3 */
                /** @var UploadedFile|null $img4 */
                /** @var UploadedFile|null $img5 */
                /** @var UploadedFile|null $img6 */
                /** @var UploadedFile|null $img7 */
                /** @var UploadedFile|null $img8 */
                /** @var UploadedFile|null $img9 */
                /** @var UploadedFile|null $img10 */
                /** @var UploadedFile|null $img11 */
                /** @var UploadedFile|null $img12 */
                $banner = $template->getBanner();
                $img1 = $template->getImg1();
                $img2 = $template->getImg2();
                $img3 = $template->getImg3();
                $img4 = $template->getImg4();
                $img5 = $template->getImg5();
                $img6 = $template->getImg6();
                $img7 = $template->getImg7();
                $img8 = $template->getImg8();
                $img9 = $template->getImg9();
                $img10 = $template->getImg10();
                $img11 = $template->getImg11();
                $img12 = $template->getImg12();

                if (!is_null($banner)) {

                    $filename = uniqid() . '.' . $banner->guessExtension();

                    $banner->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setBanner($filename);

                    if (!is_null($originalBanner)) {
                        unlink($this->getParameter('upload_dir') . $originalBanner);
                    }
                } else {
                    $template->setBanner($originalBanner);
                }

                if (!is_null($img1)) {

                    $filename = uniqid() . '.' . $img1->guessExtension();

                    $img1->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg1($filename);

                    if (!is_null($originalImg1)) {
                        unlink($this->getParameter('upload_dir') . $originalImg1);
                    }
                } else {
                    $template->setImg1($originalImg1);
                }

                if (!is_null($img2)) {

                    $filename = uniqid() . '.' . $img2->guessExtension();

                    $img2->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg2($filename);

                    if (!is_null($originalImg2)) {
                        unlink($this->getParameter('upload_dir') . $originalImg2);
                    }
                } else {
                    $template->setImg2($originalImg2);
                }

                if (!is_null($img3)) {

                    $filename = uniqid() . '.' . $img3->guessExtension();

                    $img3->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg3($filename);

                    if (!is_null($originalImg3)) {
                        unlink($this->getParameter('upload_dir') . $originalImg3);
                    }
                } else {
                    $template->setImg3($originalImg3);
                }

                if (!is_null($img4)) {

                    $filename = uniqid() . '.' . $img4->guessExtension();

                    $img4->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg4($filename);

                    if (!is_null($originalImg4)) {
                        unlink($this->getParameter('upload_dir') . $originalImg4);
                    }
                } else {
                    $template->setImg4($originalImg4);
                }

                if (!is_null($img5)) {

                    $filename = uniqid() . '.' . $img5->guessExtension();

                    $img5->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg5($filename);

                    if (!is_null($originalImg5)) {
                        unlink($this->getParameter('upload_dir') . $originalImg5);
                    }
                } else {
                    $template->setImg5($originalImg5);
                }

                if (!is_null($img6)) {

                    $filename = uniqid() . '.' . $img6->guessExtension();

                    $img6->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg6($filename);

                    if (!is_null($originalImg6)) {
                        unlink($this->getParameter('upload_dir') . $originalImg6);
                    }
                } else {
                    $template->setImg6($originalImg6);
                }

                if (!is_null($img7)) {

                    $filename = uniqid() . '.' . $img7->guessExtension();

                    $img7->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg7($filename);

                    if (!is_null($originalImg7)) {
                        unlink($this->getParameter('upload_dir') . $originalImg7);
                    }
                } else {
                    $template->setImg7($originalImg7);
                }

                if (!is_null($img8)) {

                    $filename = uniqid() . '.' . $img8->guessExtension();

                    $img8->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg8($filename);

                    if (!is_null($originalImg8)) {
                        unlink($this->getParameter('upload_dir') . $originalImg8);
                    }
                } else {
                    $template->setImg8($originalImg8);
                }

                if (!is_null($img9)) {

                    $filename = uniqid() . '.' . $img9->guessExtension();

                    $img9->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg9($filename);

                    if (!is_null($originalImg9)) {
                        unlink($this->getParameter('upload_dir') . $originalImg9);
                    }
                } else {
                    $template->setImg9($originalImg9);
                }

                if (!is_null($img10)) {

                    $filename = uniqid() . '.' . $img10->guessExtension();

                    $img10->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg10($filename);

                    if (!is_null($originalImg10)) {
                        unlink($this->getParameter('upload_dir') . $originalImg10);
                    }
                } else {
                    $template->setImg10($originalImg10);
                }

                if (!is_null($img11)) {

                    $filename = uniqid() . '.' . $img11->guessExtension();

                    $img11->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg11($filename);

                    if (!is_null($originalImg11)) {
                        unlink($this->getParameter('upload_dir') . $originalImg11);
                    }
                } else {
                    $template->setImg11($originalImg11);
                }

                if (!is_null($img12)) {

                    $filename = uniqid() . '.' . $img12->guessExtension();

                    $img12->move(
                        $this->getParameter('upload_dir'),
                        $filename
                    );

                    $template->setImg12($filename);

                    if (!is_null($originalImg12)) {
                        unlink($this->getParameter('upload_dir') . $originalImg12);
                    }

                } else {
                    $template->setImg12($originalImg12);
                }

                $manager->persist($template);
                $manager->flush();
                dump($template);

                return $this->redirectToRoute(
                    'app_admin_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            }
        }

        return $this->render(
            'admin/article/render_i_article.html.twig',
            [
                'form' => $form->createView(),
                'original_banner' => $originalBanner,
                'original_image1' => $originalImg1,
                'original_image2' => $originalImg2,
                'original_image3' => $originalImg3,
                'original_image4' => $originalImg4,
                'original_image5' => $originalImg5,
                'original_image6' => $originalImg6,
                'original_image7' => $originalImg7,
                'original_image8' => $originalImg8,
                'original_image9' => $originalImg9,
                'original_image10' => $originalImg10,
                'original_image11' => $originalImg11,
                'original_image12' => $originalImg12
            ]
        );
    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"})
     */
    public function RenderImageTemplate(Request $request, EntityManagerInterface $manager,
                                        Article $article,CommentRepository $repository,$id)
    {
        $templateImage = $article->getTemplateImageid();
        $templateText = $article->getTemplateTextid();
        $templateMixed = $article->getTemplateMixedid();


        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $comment
                    ->setUserid($this->getuser())
                    ->setArticleid($article);
                $manager->persist($comment);
                $manager->flush();

                $this->addFlash('success', 'Votre commentaire est enregistré');

                return $this->redirectToRoute(
                    'app_admin_article_renderimagetemplate',
                    [
                        'id' => $article->getId()
                    ]
                );
            } else {
                $this->addFlash('error', 'Le formulaire contient erreurs');
            }

        }
        $comments=$repository->findBy(['articleid' =>$id], ['id' => 'DESC']);

        return $this->render(
            'article/render_image_template.html.twig',
            [
                'templateImage' => $templateImage,
                'templateText' => $templateText,
                'templateMixed' => $templateMixed,
                'article' => $article,
                'comments'=>$comments,
                'form' => $form->createView()
            ]

        );

    }

    /**
     * @Route("/suppression/{id}", requirements={"id": "\d+"})
     */
    public function deleteArticleTemplate(Article $article, EntityManagerInterface $manager)
    {

        $imageTemplateId = $article->getNameTemplate();
        $textTemplateId = $article->getNameTemplate();
        $mixedTemplateId = $article->getTemplateMixedid();

        if ($imageTemplateId->getId() == '1') {

            $imageTemplate = $article->getTemplateImageid();
            if (!is_null($imageTemplate->getBanner())) {
                $banner = $this->getParameter('upload_dir') . $imageTemplate->getBanner();

                if (file_exists($banner)) {
                    unlink($banner);
                }
            }
            if (!is_null($imageTemplate->getImg1())) {
                $img1 = $this->getParameter('upload_dir') . $imageTemplate->getImg1();

                if (file_exists($img1)) {
                    unlink($img1);
                }
            }
            if (!is_null($imageTemplate->getImg2())) {
                $img2 = $this->getParameter('upload_dir') . $imageTemplate->getImg2();

                if (file_exists($img2)) {
                    unlink($img2);
                }
            }
            if (!is_null($imageTemplate->getImg3())) {
                $img3 = $this->getParameter('upload_dir') . $imageTemplate->getImg3();

                if (file_exists($img3)) {
                    unlink($img3);
                }
            }
            if (!is_null($imageTemplate->getImg4())) {
                $img4 = $this->getParameter('upload_dir') . $imageTemplate->getImg4();

                if (file_exists($img4)) {
                    unlink($img4);
                }
            }
            if (!is_null($imageTemplate->getImg5())) {
                $img5 = $this->getParameter('upload_dir') . $imageTemplate->getImg5();

                if (file_exists($img5)) {
                    unlink($img5);
                }
            }
            if (!is_null($imageTemplate->getImg6())) {
                $img6 = $this->getParameter('upload_dir') . $imageTemplate->getImg6();

                if (file_exists($img6)) {
                    unlink($img6);
                }
            }
            if (!is_null($imageTemplate->getImg7())) {
                $img7 = $this->getParameter('upload_dir') . $imageTemplate->getImg7();

                if (file_exists($img7)) {
                    unlink($img7);
                }
            }
            if (!is_null($imageTemplate->getImg8())) {
                $img8 = $this->getParameter('upload_dir') . $imageTemplate->getImg8();

                if (file_exists($img8)) {
                    unlink($img8);
                }
            }
            if (!is_null($imageTemplate->getImg9())) {
                $img9 = $this->getParameter('upload_dir') . $imageTemplate->getImg9();

                if (file_exists($img9)) {
                    unlink($img9);
                }
            }
            if (!is_null($imageTemplate->getImg10())) {
                $img10 = $this->getParameter('upload_dir') . $imageTemplate->getImg10();

                if (file_exists($img10)) {
                    unlink($img10);
                }
            }
            if (!is_null($imageTemplate->getImg11())) {
                $img11 = $this->getParameter('upload_dir') . $imageTemplate->getImg11();

                if (file_exists($img11)) {
                    unlink($img11);
                }
            }
            if (!is_null($imageTemplate->getImg12())) {
                $img12 = $this->getParameter('upload_dir') . $imageTemplate->getImg12();

                if (file_exists($img12)) {
                    unlink($img12);
                }
            }
            $manager->remove($imageTemplate);
        } elseif ($textTemplateId->getId() == '2') {

            $textTemplate = $article->getTemplateTextid();
            if (!is_null($textTemplate->getBanner())) {
                $banner = $this->getParameter('upload_dir') . $textTemplate->getBanner();

                if (file_exists($banner)) {
                    unlink($banner);
                }
            }
            if (!is_null($textTemplate->getImg1())) {
                $img1 = $this->getParameter('upload_dir') . $textTemplate->getImg1();

                if (file_exists($img1)) {
                    unlink($img1);
                }
            }
            if (!is_null($textTemplate->getImg2())) {
                $img2 = $this->getParameter('upload_dir') . $textTemplate->getImg2();

                if (file_exists($img2)) {
                    unlink($img2);
                }
            }
            $manager->remove($textTemplate);

        } elseif ($mixedTemplateId->getId() == '3') {

            $mixedTemplate = $article->getTemplateMixedid();
            if (!is_null($mixedTemplate->getBanner())) {
                $banner = $this->getParameter('upload_dir') . $mixedTemplate->getBanner();

                if (file_exists($banner)) {
                    unlink($banner);
                }
            }
            if (!is_null($mixedTemplate->getImg1())) {
                $img1 = $this->getParameter('upload_dir') . $mixedTemplate->getImg1();

                if (file_exists($img1)) {
                    unlink($img1);
                }
            }
            if (!is_null($mixedTemplate->getImg2())) {
                $img2 = $this->getParameter('upload_dir') . $mixedTemplate->getImg2();

                if (file_exists($img2)) {
                    unlink($img2);
                }
            }
            if (!is_null($mixedTemplate->getCarouselImg1())) {
                $carouselImg1 = $this->getParameter('upload_dir') . $mixedTemplate->getCarouselImg1();

                if (file_exists($carouselImg1)) {
                    unlink($carouselImg1);
                }
            }
            if (!is_null($mixedTemplate->getCarouselImg2())) {
                $carouselImg2 = $this->getParameter('upload_dir') . $mixedTemplate->getCarouselImg2();

                if (file_exists($carouselImg2)) {
                    unlink($carouselImg2);
                }
            }
            if (!is_null($mixedTemplate->getCarouselImg3())) {
                $carouselImg3 = $this->getParameter('upload_dir') . $mixedTemplate->getCarouselImg3();

                if (file_exists($carouselImg3)) {
                    unlink($carouselImg3);
                }
            }
            if (!is_null($mixedTemplate->getCarouselImg4())) {
                $carouselImg4 = $this->getParameter('upload_dir') . $mixedTemplate->getCarouselImg4();

                if (file_exists($carouselImg4)) {
                    unlink($carouselImg4);
                }
            }
            if (!is_null($mixedTemplate->getCarouselImg5())) {
                $carouselImg5 = $this->getParameter('upload_dir') . $mixedTemplate->getCarouselImg5();

                if (file_exists($carouselImg5)) {
                    unlink($carouselImg5);
                }
            }
            $manager->remove($mixedTemplate);

        }

        $manager->remove($article);
        $manager->flush();

//        $this->addFlash('success', 'L\'article est supprimmée');

        return $this->redirectToRoute('app_admin_article_index');

    }
}
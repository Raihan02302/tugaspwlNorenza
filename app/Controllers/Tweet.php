<?php

namespace App\Controllers;

use \App\Models\TweetModel;

class Tweet extends BaseController
{

    var $categories;
    var $sess;
    var $curUser;

    var $tweetMdl;
    var $profile;

    public function __construct()
    {
        $this->categories = (new \Config\AdtConfig())->getCategories();
        $this->sess = session();
        $this->curUser = $this->sess->get('currentuser');

        $this->tweetMdl = new TweetModel();
        $userMdl = new \App\Models\UserModel();
        $this->profile = $userMdl->find($this->curUser['userid']);
    }

    public function index()
    {
        $data['categories'] = $this->categories;
        $data['judul'] = 'Tweet Terbaru';

        $data['profile'] = $this->profile;
        $data['tweets'] = $this->tweetMdl->getLatest();
        $data['curUser'] = $this->curUser;

        return view('tweet_home', $data);
    }

    public function category($category)
    {
        $data['categories'] = $this->categories;
        $data['judul'] = 'Tweet Terbaru';
        $data['curUser'] = $this->curUser;
        $data['profile'] = $this->profile;
        $data['tweets'] = $this->tweetMdl->getByCategory($category);

        return view('tweet_home', $data);
    }

    public function addForm()
    {
        $data['categories'] = $this->categories;
        return view('tweet_add', $data);
    }

    public function editForm($tweet_id)
    {
        $tweet = $this->tweetMdl->find($tweet_id);
        if ($tweet->user_id != $this->sess->get('currentuser')['userid']) {
            $this->sess->set('edittweet', 'error');
            return redirect()->to('/');
        }

        $data['categories'] = $this->categories;
        $data['tweet'] = $tweet;
        return view('tweet_edit', $data);
    }


    public function delTweet($tweet_id)
    {
        $result = $this->tweetMdl->delTweet($this->sess->get('currentuser')['userid'], $tweet_id);
        if ($result) {
            $this->sess->setFlashdata('deltweet', 'success');
        } else {
            $this->sess->setFlashdata('deltweet', 'error');
        }
        return redirect()->to('/');
    }

    public function editTweet()
    {
        $result = $this->tweetMdl->editTweet($this->request->getPost());
        if ($result) {
            $this->sess->setFlashdata('edittweet', 'success');
        } else {
            $this->sess->setFlashdata('edittweet', 'error');
        }

        return redirect()->to('/');
    }

    public function like($tweet_id)
    {
        // Check if the form is submitted and the like button is clicked
        if ($this->request->getMethod() === 'post' && $this->request->getPost('like') !== null) {
            $tweet = $this->tweetMdl->find($tweet_id);

            if ($tweet) {
                $like = !$tweet->like; // Toggle the like status
                $updated = $this->tweetMdl->update($tweet_id, ['like' => $like]);

                if ($updated) {
                    $this->sess->setFlashdata('liketweet', 'success');
                } else {
                    $this->sess->setFlashdata('liketweet', 'error');
                }
            } else {
                $this->sess->setFlashdata('liketweet', 'error');
            }
        }

        return redirect()->to('/');
    }


    public function addTweet()
    {
        $this->request->setGlobal('multipart', true); // Enable multipart form data

        // Retrieve form data
        $postData = $this->request->getPost();
        $photo = $this->request->getFile('uphoto');

        // Check if a photo was uploaded
        if ($photo->isValid() && !$photo->hasMoved()) {
            // Move the uploaded photo to the desired directory
            $newFileName = $photo->getRandomName();
            $photo->move('asset/uploads', $newFileName);

            // Update the tweet data with the photo file path
            $postData['uphoto'] = 'asset/uploads/' . $newFileName;
        }

        // Create the tweet
        $this->tweetMdl->newTweet($this->sess->get('currentuser'), $postData);
        $this->sess->setFlashdata('addtweet', 'success');
        return redirect()->to('/');
    }
}

<?php

namespace onefasteuro\Shopify\Endpoints;



class Webhooks extends BaseEndpoint
{
	
	public function all($next = null)
	{
		$call = '{
	    webhookSubscriptions(first: 10' . (($next != null) ? ', after: "' . $next . '"' : '') . ') {
	       pageInfo {
	        hasNextPage
	       }
	       edges {
	        cursor
	        node {
	            id
	            topic
	            callbackUrl
	        }
	    }
	}
}
';
		return $this->client->query($call);
	}
	
	public function delete($id)
	{
		$call = '
        mutation {
            webhookSubscriptionDelete(id: "' . $id .'")
            {
				userErrors {
					field
					message
				}
				deletedWebhookSubscriptionId
			}
        }
        ';
		
		return $this->client->query($call);
	}
	
	public function create($url, $topic)
	{
		$call = '
        mutation {
            webhookSubscriptionCreate(topic: ' .$topic .', webhookSubscription: {
                callbackUrl: "' . $url . '"
                format: JSON
                includeFields: id
            }),
            {
				userErrors {
					field
					message
				}
				webhookSubscription {
					callbackUrl
					format
					id
					includeFields
					topic
				}
			}
        }
        ';
		
		return $this->client->query($call);
	}
	
	
	public function setVisibility($namespace, $key, $owner)
	{
		/*
		$query = '
        mutation {
            metafieldStorefrontVisibilityCreate(input: {
                namespace: "stamped",
                key: "reviews_count",
                ownerType: PRODUCT
            }),
            {
                metafieldStorefrontVisibility {
			        id
				},
				userErrors {
					field,
					message
				}
			}
        }
        ';
		
		return $this->client->query($query, 'metafieldStorefrontVisibilityCreate');
		*/
	}
	
}
import React from "react";
import Container from "../../components/ui/Container";
import Avatar from "../../components/ui/Avatar";
export function ThemeItem({titre, icon,NArticles, description,avatarUrl}) {
  return <Container className={"shadow-md"}>
                            <div className="flex items-center justify-center mr-3  ">
                                {icon && icon} 
                                {avatarUrl && <Avatar size="sm"/>}
                            </div>
                            
                            <div className="flex flex-col">
                                <h5>{titre}</h5>
                                <p className="text-secondary-text font-light">{NArticles} {description}</p>
                            </div>
          </Container>;
}
  